<?php
/**
 * PHP Grid Component
 *
 * @author Abu Ghufran <gridphp@gmail.com> - http://www.phpgrid.org
 * @version 1.4.8 build 105-20130424
 * @license: see license.txt included in package
 */
 
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set("display_errors","off");

class zf_phpgrid
{
	// grid parameters
	var $options = array();

	// nav grid parameters
	var $navgrid = array();

	// internal use params
	var $internal = array();
	
	// select query to show data
	var $select_command;
	
	// db table name used in add,update,delete
	var $table;
	
	// allowed operation on grid
	var $actions;

	### P ###
	// var for conditional css data
	var $conditional_css;

	### P ###
	// var for conditional css data
	var $group_header;

	// show server error
	var $debug;
	
	// db connection identifier - not used now, @todo: need to integrate adodb lib
	var $con;
	var $db_driver;
		
	// callback events
	var $events;
	
	
	/**
	 * Contructor to set default params
	 */
	function zf_phpgrid($db_conf = null)
	{
            
		if (!isset($_SESSION) || !is_array($_SESSION))
			session_start();

		$this->db_driver = "mysql";
		$this->debug = 1;
		// shown in case of debug = 0
		$this->error_msg = "Some issues occured in this operation, Contact technical support for help";
		
		// set utf8 encoding
		mysql_query("SET NAMES 'utf8'");

		### P ###
		// use adodb layer to support non-mysql dbs
		if ($db_conf)
		{
			// set up DB
			include(ZF_PLUGINS."adodb5/adodb.inc.php");
			$driver = $db_conf["type"];
			$this->con = ADONewConnection($driver); # eg. 'mysql,oci8(for oracle),mssql,postgres,sybase' 
			$this->con->SetFetchMode(ADODB_FETCH_ASSOC);
			$this->con->debug = 0;
	
			//$this->con->Connect($db_conf["server"], $db_conf["user"], $db_conf["password"], $db_conf["database"]);
			$this->con->Connect($db_conf["server"], $db_conf["user"], $db_conf["password"], $db_conf["database"]);
	
			// set your db encoding -- for ascent chars (if required)	
			if ($db_conf["type"] == "mysql")
				$this->con->Execute("SET NAMES 'utf8'");
		
			$this->db_driver = $db_conf["type"];
		}
		
		$grid["datatype"] = "json";
		$grid["rowNum"] = 20;
		$grid["width"] = 950;
		$grid["height"] = 150;
		$grid["rowList"] = array(10,20,30);
		$grid["viewrecords"] = true;
		$grid["scrollrows"] = true;
		$grid["toppager"] = false;
		// renamed qstr variable due to wordpress conflict
		$grid["prmNames"] = array("page"=>"jqgrid_page");

		// default sort options (first field and asc)
		$grid["sortname"] = "1";
		$grid["sortorder"] = "asc";
		$grid["form"]["nav"] = false;
		
		$protocol = ( ($_SERVER['HTTPS'] == "on" || $_SERVER["SERVER_PORT"] == "443" ) ? "https" : "http");
		$grid["url"] = "$protocol://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"];
		
		### P ###
		// pass subgrid params if exist
		$s = (strstr($grid["url"], "?")) ? "&":"?";
		if (isset($_REQUEST["rowid"]) && isset($_REQUEST["subgrid"]))
			$grid["url"] .= $s."rowid=".$_REQUEST["rowid"]."&subgrid=".$_REQUEST["subgrid"];
		
		// persist rowid in session and get (for export fix master-detail's detail grid case)
		if (!empty($_GET["rowid"]))
			$_SESSION["rowid"] = $_GET["rowid"];
		$_GET["rowid"] = $_SESSION["rowid"];
		### P-END ###

		$grid["editurl"] = $grid["url"];
		$grid["cellurl"] = $grid["url"];
		
		// virtual scrolling, for big datasets
		$grid["scroll"] = 0;
		$grid["sortable"] = true;
		$grid["cellEdit"] = false;

		### P ###
		// if specific export is requested
		if (isset($_GET["export_type"]) && ($_GET["export_type"] == "xlsx" || $_GET["export_type"] == "excel"))
			$grid["export"]["format"] = "excel";
		else if (isset($_GET["export_type"]) && $_GET["export_type"] == "pdf")
			$grid["export"]["format"] = "pdf";
		else if (isset($_GET["export_type"]) && $_GET["export_type"] == "csv")
			$grid["export"]["format"] = "csv";

		// default pdf export options
		$grid["export"]["paper"] = "a4";
		$grid["export"]["orientation"] = "landscape";
		### P-END ###		

		$grid["add_options"] = array("recreateForm" => true, "closeAfterAdd"=>true, 
										"errorTextFormat"=> "function(r){ return r.responseText;}", "modal" => true
										);
		$grid["edit_options"] = array("recreateForm" => true, "closeAfterEdit"=>true, 
										"errorTextFormat" => "function(r){ return r.responseText;}", "modal" => true
										);
		$grid["delete_options"] = array("errorTextFormat"=> "function(r){ return r.responseText;}"
										);
		
		$grid["form"]["position"] = "";

		$this->options = $grid;	
		
		$this->actions["showhidecolumns"] = false;
		$this->actions["inlineadd"] = false;
		$this->actions["search"] = "";
		$this->actions["export"] = false;
	}

	/**
	 * Helping function to parse array
	 */
	private function strip($value)
	{
		// gpc line removed for wp plugin search fix
		// if(get_magic_quotes_gpc() != 0)
		{
			if(is_array($value))  
				if ( array_is_associative($value) )
				{
					foreach( $value as $k=>$v)
						$tmp_val[$k] = stripslashes($v);
					$value = $tmp_val; 
				}				
				else  
					for($j = 0; $j < sizeof($value); $j++)
						$value[$j] = stripslashes($value[$j]);
			else
				$value = stripslashes($value);
		}
		return $value;
	}	
	
	/**
	 * Advance search where clause maker
	 */
	private function construct_where($s)
	{
		$qwery = "";
		//['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc']
		$qopers = array(
					  'eq'=>" = ",
					  'ne'=>" <> ",
					  'lt'=>" < ",
					  'le'=>" <= ",
					  'gt'=>" > ",
					  'ge'=>" >= ",
					  'bw'=>" LIKE ",
					  'bn'=>" NOT LIKE ",
					  'in'=>" IN ",
					  'ni'=>" NOT IN ",
					  'ew'=>" LIKE ",
					  'en'=>" NOT LIKE ",
					  'cn'=>" LIKE " ,
					  'nc'=>" NOT LIKE " );
		if ($s) {
			$jsona = json_decode($s,true);
			if(is_array($jsona))
			{
				$gopr = $jsona['groupOp'];
				$rules = $jsona['rules'];
				$i =0;
				foreach($rules as $key=>$val) 
				{
					# fix for conflicting table name fields (used alias from page, in property dbname)
					foreach($this->options["colModel"] as $link_c)
					{
						if ($val['field'] == $link_c["name"] && !empty($link_c["dbname"]))
						{
							$val['field'] = $link_c["dbname"];
						}

						// fix for d/m/Y date format. strtotime expects m/d/Y
						if ($val['field'] == $link_c["name"] && $link_c["formatter"] == "date")
						{
							if ($link_c["formatoptions"]["newformat"] == "d/m/Y")
							{
								$tmp = explode("/",$val['data']);
								$val['data'] = $tmp[1]."/".$tmp[0]."/".$tmp[2];
							}
							$val['data'] = date("Y-m-d",strtotime($val['data']));
						}
					}
			
					$field = $val['field'];
					$op = $val['op'];
					$v = $val['data'];
					if(isset($v) && isset($op))
					{
						$i++;
						// ToSql in this case is absolutley needed
						$v = $this->to_sql($field,$op,$v);
			
						if ($i == 1) $qwery = " AND ";
						else $qwery .= " " .$gopr." ";
						switch ($op) {
							// in need other thing
							case 'in' :
							case 'ni' :
								$qwery .= $field.$qopers[$op]." (".$v.")";
								break;
							case 'cn' :
							case 'bw' :
								$qwery .= "LOWER($field)".$qopers[$op]." LOWER(".$v.")";
								break;
							default:
								$qwery .= $field.$qopers[$op].$v;
						}
					}
				}
			}
		}
		return $qwery;
		
	}	

	/**
	 * Advance search, make search operator sql compatible
	 */
	private function to_sql($field, $oper, $val) 
	{
		//mysql_real_escape_string is better
		if($oper=='bw' || $oper=='bn') return "'" . addslashes($val) . "%'";
		else if ($oper=='ew' || $oper=='en') return "'%" . addcslashes($val) . "'";
		else if ($oper=='cn' || $oper=='nc') return "'%" . addslashes($val) . "%'";
		else return "'" . addslashes($val) . "'";
	}
	
	### P ###
	/**
	 * Setter for event handler
	 */
	function set_events($arr)
	{
		$this->events = $arr;
	}

	### P ###
	/**
	 * Get dropdown values for select dropdowns
	 */	
	function get_dropdown_values($sql)
	{
		$str = array();
		$result = $this->execute_query($sql);

		if ($this->con)
		{
			$arr = $result->GetRows();
			
			foreach($arr as $rs)
			{
				$rs["k"] = (!empty($rs["K"])) ? $rs["K"] : $rs["k"];
				$rs["v"] = (!empty($rs["V"])) ? $rs["V"] : $rs["v"];

				$str[] = $rs["k"].":".$rs["v"];
			}
		}
		else
		{
			while($rs = mysql_fetch_array($result,MYSQL_ASSOC))
			{
				$str[] = $rs["k"].":".$rs["v"];
			}
		}
				
		$str = implode($str,";");
		return $str;
	}
	
	/**
	 * Setter for allowed actions (add/edit/del/autofilter etc)
	 */
	function set_actions($arr)
	{
		if (empty($arr))
			$arr = array();		
			
		if (empty($this->actions))
			$this->actions = array();
			
		// for add_option array
		foreach($arr as $k=>$v)
			if (is_array($v))
			{
				if (!isset($this->actions[$k]))
					$this->actions[$k] = array();
					
				$arr[$k] = array_merge($arr[$k],$this->actions[$k]);
			}		
			
		$this->actions = array_merge($this->actions,$arr);
	}
	
	/**
	 * Setter for grid customization options
	 */
	function set_options($options)
	{
		if (empty($arr))
			$arr = array();

		if (empty($this->options))
			$this->options = array();

		if (isset($options["rowList"]))
			unset($this->options["rowList"]);

		// for export like array merge
		foreach($options as $k=>$v)
			if (is_array($v))
			{
				if (!isset($this->options[$k]))
					$this->options[$k] = array();
					
				$options[$k] = array_merge($this->options[$k],$options[$k]);
			}
			
		$this->options = array_merge($this->options,$options);

		$this->options["editurl"] = $this->options["url"];
		$this->options["cellurl"] = $this->options["url"];

		// enable form prev/next buttons. disabled by default now
		$show_form_nav = '';
		if ($this->options["form"]["nav"] === true)
		{
			$show_form_nav = '$("#pData").show(); $("#nData").show();';
		}
		else
		{
			$show_form_nav = '$("#pData").hide(); $("#nData").hide();';
		}

		$this->internal["add_options"]["beforeShowForm"] = $show_form_nav;
		$this->internal["edit_options"]["beforeShowForm"] = $show_form_nav;
		$this->internal["delete_options"]["beforeShowForm"] = $show_form_nav;

		// toolbar position
		if (isset($this->options["toolbar"]) && $this->options["toolbar"] != "bottom")
		{
			$this->options["toppager"] = true;

			// fix for initially hidden grid
			if ($this->options["hiddengrid"] == true && $this->options["toolbar"] == "top")
				$this->options["toolbar"] = "both";
		}

		if ($this->options["form"]["position"] == "center")
		{
			$this->internal["add_options"]["beforeShowForm"] .= '	// align dialog to center
																	var gid = formid.attr("id").replace("FrmGrid_","");
																	var dlgDiv = $("#editmod" + gid);
																	var parentDiv = dlgDiv.parent(); // div#gbox_list
																	var dlgWidth = dlgDiv.width();
																	var parentWidth = parentDiv.width();
																	var dlgHeight = dlgDiv.height();
																	var parentHeight = parentDiv.height();
																	// TODO: change parentWidth and parentHeight in case of the grid
																	//       is larger as the browser window
																	dlgDiv[0].style.top = jQuery(parentDiv).position().top + Math.round((parentHeight-dlgHeight)/2) + "px";
																	dlgDiv[0].style.left = jQuery(parentDiv).position().left + Math.round((parentWidth-dlgWidth)/2) + "px";	
																';	

			$this->internal["edit_options"]["beforeShowForm"] .= '
																	// align dialog to center
																	var gid = formid.attr("id").replace("FrmGrid_","");
																	var dlgDiv = $("#editmod" + gid);
																	var parentDiv = dlgDiv.parent(); // div#gbox_list
																	var dlgWidth = dlgDiv.width();
																	var parentWidth = parentDiv.width();
																	var dlgHeight = dlgDiv.height();
																	var parentHeight = parentDiv.height();
																	// TODO: change parentWidth and parentHeight in case of the grid
																	//       is larger as the browser window
																	dlgDiv[0].style.top = jQuery(parentDiv).position().top + Math.round((parentHeight-dlgHeight)/2) + "px";
																	dlgDiv[0].style.left = jQuery(parentDiv).position().left + Math.round((parentWidth-dlgWidth)/2) + "px";	
																';

			$this->internal["delete_options"]["beforeShowForm"] .= '
																	// align dialog to center
																	var gid = formid.attr("id").replace("DelTbl_","");
																	var dlgDiv = $("#delmod" + gid);
																	var parentDiv = dlgDiv.parent(); // div#gbox_list
																	var dlgWidth = dlgDiv.width();
																	var parentWidth = parentDiv.width();
																	var dlgHeight = dlgDiv.height();
																	var parentHeight = parentDiv.height();
																	// TODO: change parentWidth and parentHeight in case of the grid
																	//       is larger as the browser window
																	dlgDiv[0].style.top = jQuery(parentDiv).position().top + Math.round((parentHeight-dlgHeight)/2) + "px";
																	dlgDiv[0].style.left = jQuery(parentDiv).position().left + Math.round((parentWidth-dlgWidth)/2) + "px";	
																';
			unset($this->options["form"]["position"]);
		}
	}

	### P ###
	function set_conditional_css($params)
	{
		$this->conditional_css = $params;
	}

	### P ###
	function set_group_header($params)
	{
		$this->group_header = $params;
	}

	/**
	 * Auto generate columns for grid based on SQL / table
	 */
	function set_columns($cols = null)
	{
		if (!$this->table && !$this->select_command) die("Please specify tablename or select command");
		
		// if loading from array
		if (is_array($this->table))
		{
			### P ###
			$arr = $this->table;
			$f = array_keys($arr[0]);
		}
		else
		{
			// if only table is defined, make select sql for it
			if (!$this->select_command && $this->table)
				$this->select_command = "SELECT * FROM ".$this->table;

			// add where clause if not present -- fix for search feature
			if (stristr($this->select_command,"WHERE") === false)
			{
				// place group by at proper position in sql
				if (($p = stripos($this->select_command,"GROUP BY")) !== false)
				{
					$start = substr($this->select_command,0,$p);
					$end = substr($this->select_command,$p);
					$this->select_command = $start." WHERE 1=1 ".$end;
				}
				else
					$this->select_command .= " WHERE 1=1";
			}

			// make sql on single line, with no extra spaces
			$this->select_command = preg_replace("/(\r|\n)/"," ",$this->select_command);
			$this->select_command = preg_replace("/[ ]+/"," ",$this->select_command);

			// get sql column names by running nulled sql
			$sql = $this->select_command . " LIMIT 1 OFFSET 0";
			
			$sql = $this->prepare_sql($sql,$this->db_driver);
			
			$result = $this->execute_query($sql);

			if ($this->con)
			{
				$arr = $result->FetchRow();
				if (!empty($arr))
					foreach($arr as $k=>$rs)
						$f[] = $k;
			}	
			else
			{		
				$numfields = mysql_num_fields($result);
				for ($i=0; $i < $numfields; $i++) // Header
				{
					$f[] = mysql_field_name($result, $i);
				}
			}			
		}

		// if grid columns not defined, make from sql
		if (!$cols)
		{
			foreach($f as $c)
			{
				$col["title"] = ucwords(str_replace("_"," ",$c));
				$col["name"] = $c;
				$col["index"] = $c;
				$col["editable"] = true;
				$col["editoptions"] = array("size"=>20);
				$g_cols[] = $col;
			}
		}
		
		if (!$cols)
			$cols = $g_cols;
			
		// index attr is must for jqgrid, so add it in array
		for($i=0;$i<count($cols);$i++)
		{
			$cols[$i]["name"] = $cols[$i]["name"];
			$cols[$i]["index"] = $cols[$i]["name"];
			if ($cols[$i]["editrules"]["required"] == true)
				$cols[$i]["formoptions"] = array("elmsuffix"=>'<font color=red> *</font>');

			if (isset($cols[$i]["formatter"]) && $cols[$i]["formatter"] == "date" && empty($cols[$i]["formatoptions"]))
				$cols[$i]["formatoptions"] = array("srcformat"=>'Y-m-d',"newformat"=>'Y-m-d');

			$js_dt_fmt = $cols[$i]["formatoptions"]["newformat"];
			$js_dt_fmt = str_replace("Y", "yy", $js_dt_fmt);
			$js_dt_fmt = str_replace("m", "mm", $js_dt_fmt);
			$js_dt_fmt = str_replace("d", "dd", $js_dt_fmt);

			if (isset($cols[$i]["formatter"]) && $cols[$i]["formatter"] == "date")
			{
				$cols[$i]["editoptions"]["dataInit"] = "function(o){link_date_picker(o,'{$js_dt_fmt}');}";
				$cols[$i]["searchoptions"]["dataInit"] = "function(o){link_date_picker(o,'{$js_dt_fmt}',1);}";
				$cols[$i]["searchoptions"]["sopt"] = array("eq");
			}
			
			if (isset($cols[$i]["formatter"]) && $cols[$i]["formatter"] == "datetime")
			{
				$cols[$i]["editoptions"]["dataInit"] = "function(o){link_datetime_picker(o,'{$js_dt_fmt}');}";
				$cols[$i]["searchoptions"]["dataInit"] = "function(o){link_datetime_picker(o,'{$js_dt_fmt}',1);}";
				$cols[$i]["searchoptions"]["sopt"] = array("eq");
			}
			
			### P ###
			if (isset($cols[$i]["formatter"]) && $cols[$i]["formatter"] == "wysiwyg")
			{
				$cols[$i]["formatter"] = "function(cellval,options,rowdata){return $.jgrid.htmlEncode(cellval);}";
				$cols[$i]["editoptions"]["dataInit"] = "function(o){link_editor(o);}";
			}

			### P ###
			if (isset($cols[$i]["formatter"]) && $cols[$i]["formatter"] == "autocomplete")
				$cols[$i]["editoptions"]["dataInit"] = "function(o){link_autocomplete(o,'".$cols[$i]["formatoptions"]["update_field"]."');}";

			### P ###
			if ($cols[$i]["edittype"] == "file")
			{
				$this->require_upload_ajax = 1;
				$cols[$i]["editoptions"]["dataInit"] = "function(o){link_upload(o,'".$cols[$i]["name"]."');}";
				$cols[$i]["edittype"] = "text";
				$this->actions["rowactions"] = false;				
			}

			// auto reload for link pattern fix
			if (!empty($cols[$i]["link"]))
			{
				$this->options["reloadedit"] = true;
				$cols[$i]["formatter"] = "link";
			}
		}

		$this->options["colModel"] = $cols;
		foreach($cols as $c)
		{
			$this->options["colNames"][] = $c["title"];		
		}
	}

	/**
	 * Common function for db operations
	 */
	function execute_query($sql,$return="")
	{
		if ($this->con)
		{
			$ret = $this->con->Execute($sql);
			if (!$ret)
			{
				if ($this->debug)
					phpgrid_error("Couldn't execute query. ".$this->con->ErrorMsg()." - $sql");
				else
					phpgrid_error($this->error_msg);
			}

			if ($return == "insert_id")
				return $this->con->Insert_ID();
		}
		else
		{
			$ret = mysql_query($sql);
			if (!$ret)
			{
				if ($this->debug)
					phpgrid_error("Couldn't execute query. ".mysql_error()." - $sql");		
				else
					phpgrid_error($this->error_msg);
			}

			if ($return == "insert_id")
				return mysql_insert_id();
		}

		return $ret;
	}

	/**
	 * Generate JSON array for grid rendering
	 * @param $grid_id Unique ID for grid
	 */
	function render($grid_id)
	{
		// render grid for first time (non ajax), but specific grid on ajax calls
		$is_ajax = isset($_REQUEST["nd"]) || isset($_REQUEST["oper"]) || isset($_REQUEST["export"]);
		if ($is_ajax && $_REQUEST["grid_id"] != $grid_id)
			return;

		$append_by = (strpos($this->options["url"],"?") === false) ? "?" : "&";

		$this->options["url"] .= $append_by."grid_id=$grid_id";
		$this->options["editurl"] .= $append_by."grid_id=$grid_id";
		$this->options["cellurl"] .= $append_by."grid_id=$grid_id";
		
		if (isset($_REQUEST["subgrid"]))
			$grid_id .= "_".preg_replace("/[^a-zA-Z0-9]+/", "", $_REQUEST["subgrid"]);

			
		// generate column names, if not defined
		if (!$this->options["colNames"])
			$this->set_columns();
			
		### P ###
		// manage uploaded files
		if (count($_FILES))
		{
			$files = array_keys($_FILES);
			$fileElementName = $files[0];

			if(!empty($_FILES[$fileElementName]['error']))
			{
				switch($_FILES[$fileElementName]['error'])
				{
					case '1':
						$error = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
						break;
					case '2':
						$error = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
						break;
					case '3':
						$error = 'The uploaded file was only partially uploaded';
						break;
					case '4':
						$error = 'No file was uploaded.';
						break;

					case '6':
						$error = 'Missing a temporary folder';
						break;
					case '7':
						$error = 'Failed to write file to disk';
						break;
					case '8':
						$error = 'File upload stopped by extension';
						break;
					case '999':
					default:
						$error = 'No error code avaiable';
				}
			}
			elseif(empty($_FILES[$fileElementName]['tmp_name']) || $_FILES[$fileElementName]['tmp_name'] == 'none')
			{
				$error = 'No file was uploaded';
			}
			else 
			{
				foreach($this->options["colModel"] as $c)
				{
					if ($c["upload_dir"] != "" && $c["name"] == $fileElementName)
					{
						$tmp_name = $_FILES[$fileElementName]["tmp_name"];
						$name = $_FILES[$fileElementName]["name"];
						
						$uploads_dir = $c["upload_dir"];
						mkdir($uploads_dir,0755,true);

						if (move_uploaded_file($tmp_name, "$uploads_dir/$name"))
						{
							$field = $_POST["field"];
							$msg = "$uploads_dir/$name";
						}
						else
							$error = "Unable to move to desired folder $uploads_dir/$name";

						break;
					}
				}
			}
			
			echo "{";
			echo	"error: '" . $error . "',\n";
			echo	"msg: '" . $msg . "'\n";
			echo "}";			
			die;
		}
		### P-END ###
		
		if (isset($_POST['oper']))
		{
			$op = $_POST['oper'];
			$data = $_POST;
			$id = $data['id'];
			$pk_field = $this->options["colModel"][0]["index"];
			
			// formatters array for k->v
			$formatters = array();

			// reformat date w.r.t mysql
			foreach( $this->options["colModel"] as $c )
			{
				// don't fix vars that are not posted (celledit mode)
				if (!isset($data[$c["index"]]))
					continue;

				// fix for short weekday name 
				if (strstr($c["formatoptions"]["newformat"],"D"))
				{
					$data[$c["index"]] = str_ireplace(array("sun","mon","tue","wed","thu","fri","sat"), "", $data[$c["index"]]);
					$data[$c["index"]] = trim($data[$c["index"]]);
				}

				// fix for d/m/Y date format. strtotime expects m/d/Y
				if (strstr($c["formatoptions"]["newformat"],"d/m/Y"))
				{
					$tmp = explode("/",$data[$c["index"]]);
					$data[$c["index"]] = $tmp[1]."/".$tmp[0]."/".$tmp[2];
				}

				// put zeros for blank date field
				if (($c["formatter"] == "date" || $c["formatter"] == "datetime") && (empty($data[$c["index"]]) || $data[$c["index"]] == "//"))
				{
					$data[$c["index"]] = "NULL";
				}
				// if db field allows null, then set NULL
				else if ($c["isnull"] && empty($data[$c["index"]]))
				{
					$data[$c["index"]] = "NULL";
				}
				else if ($c["formatter"] == "date")
				{
					$data[$c["index"]] = date("Y-m-d",strtotime($data[$c["index"]]));
				}
				else if ($c["formatter"] == "datetime")
				{
					$data[$c["index"]] = date("Y-m-d H:i:s",strtotime($data[$c["index"]]));
				}
				// remove for lookup FK data, and dont when searching in same field
				else if ($c["formatter"] == "autocomplete" && $c["index"] != $c["formatoptions"]["update_field"])
				{
					unset($data[$c["index"]]);
				}

				// k-v lookup for formatters
				$formatters[$c["index"]] = $c["formatter"];
			}

			// handle grid operations of CRUD
			switch($op)
			{
				### P ###
				case "autocomplete":
					$field = $data['element'];
					$term = $data['term'];
					foreach( $this->options["colModel"] as $c )
					{
						if ($c["index"] == $field)
						{
							// if subqurey
							if (preg_match('/SELECT (.*) \\((.*)\) (.*)/', $c["formatoptions"]["sql"], $match))
							{
								if (preg_match('/SELECT .* \\((.*)\) (.*) WHERE (.*)/', $c["formatoptions"]["sql"], $match))
									$cond = "AND";
								else
									$cond = "WHERE";
							}
							// if normal query
							else if (stristr($c["formatoptions"]["sql"], " WHERE "))
								$cond = "AND";
							else
								$cond = "WHERE";

							$sql = $c["formatoptions"]["sql"]. " $cond {$c["formatoptions"]["search_on"]} like '$term%'";
							$sql = $this->prepare_sql($sql,$this->db_driver);
							$result = $this->execute_query($sql);
							if ($this->con)
							{
								$rows = $result->GetArray();
								foreach ($rows as $key => $row) 
								{
									$arr = array();
									$arr['id'] = $row["k"];
								    $arr['label'] = $row["v"];
								    $arr['value'] = $row["v"];
								    $data_arr[] = $arr;									
								}
							}
							else
							{
								while($row = mysql_fetch_assoc($result)) 
								{
									$arr = array();
								    $arr['id'] = $row['k'];
								    $arr['label'] = $row['v'];
								    $arr['value'] = $row['v'];
								    $data_arr[] = $arr;
								}
							}

							header('Content-type: application/json');
							echo json_encode($data_arr);
							die;
						}
					}
					break;

				case "clone":
						$src_id = $data['id'];

						// get columns to build INSERT - SELECT query
						$sql = "SELECT * FROM ".$this->table . " LIMIT 1 OFFSET 0";
						$sql = $this->prepare_sql($sql,$this->db_driver);
						
						$result = $this->execute_query($sql);

						// and exclude PK
						if ($this->con)
						{
							$arr = $result->FetchRow();
							foreach($arr as $k=>$rs)
								if ($k != $pk_field)
									$f[] = $k;
						}
						else
						{		
							$numfields = mysql_num_fields($result);
							for ($i=0; $i < $numfields; $i++) // Header
							{
								$k = mysql_field_name($result, $i);
								if ($k != $pk_field)
									$f[] = $k;
							}
						}

						$fields_str = implode(",",$f);
						$sql = "INSERT INTO {$this->table} ($fields_str) SELECT $fields_str FROM {$this->table} WHERE $pk_field = $src_id";
						$insert_id = $this->execute_query($sql,"insert_id");
					break;

				case "add":
					unset($data['id']);
					unset($data['oper']);
					
					$update_str = array();

					### P ###
					// custom onupdate event execution
					if (!empty($this->events["on_insert"]))
					{
						$func = $this->events["on_insert"][0];
						$obj = $this->events["on_insert"][1];
						$continue = $this->events["on_insert"][2];
						
						if ($obj)
							call_user_method($func,$obj,array($pk_field => $id, "params" => &$data));
						else
							call_user_func($func,array($pk_field => $id, "params" => &$data));
						
						if (!$continue)
							break;
					}
					
					foreach($data as $k=>$v)
					{
						// remove any table alias from query - obseleted
						if (strstr($k,"::") !== false)
							list($tmp,$k) = explode("::",$k);
						$k = addslashes($k);
						$v = addslashes($v);
						$fields_str[] = "$k";

						$v = ($v == "NULL" || $formatters[$k] == "integer") ? $v : "'$v'";
						$values_str[] = "$v";
					}
					
					$insert_str = "(".implode(",",$fields_str).") VALUES (".implode(",",$values_str).")";
					
					$sql = "INSERT INTO {$this->table} $insert_str";

					$insert_id = $this->execute_query($sql,"insert_id");

					### P ###
					// custom onupdate event execution
					if (!empty($this->events["on_after_insert"]))
					{
						$func = $this->events["on_after_insert"][0];
						$obj = $this->events["on_after_insert"][1];
						$continue = $this->events["on_after_insert"][2];
						
						if ($obj)
							call_user_method($func,$obj,array($pk_field => $insert_id, "params" => &$data));
						else
							call_user_func($func,array($pk_field => $insert_id, "params" => &$data));
						
						if (!$continue)
							break;
					}
					
					// for inline row addition, return insert id to update PK of grid (e.g. order_id#33)
					if ($id == "new_row")
						die($pk_field."#".$insert_id);

					// return JSON response for insert id
					if (intval($insert_id)>0)
						$res = array("id" => $insert_id, "success" => true);
					else
						$res = array("id" => 0, "success" => false);

					echo json_encode($res);

					break;
					
				case "edit":
					//pr($_POST);
					unset($data['id']);
					unset($data['oper']);
					
					$update_str = array();

					### P ###
					// custom onupdate event execution
					if (!empty($this->events["on_update"]))
					{
						$func = $this->events["on_update"][0];
						$obj = $this->events["on_update"][1];
						$continue = $this->events["on_update"][2];
						
						if ($obj)
							call_user_method($func,$obj,array($pk_field => $id, "params" => &$data));
						else
							call_user_func($func,array($pk_field => $id, "params" => &$data));
						
						if (!$continue)
							break;
					}

					foreach($data as $k=>$v)
					{
						// remove any table alias from query - obseleted
						if (strstr($k,"::") !== false)
							list($tmp,$k) = explode("::",$k);
							
						$k = addslashes($k);
						$v = addslashes($v);

						$v = ($v == "NULL" || $formatters[$k] == "integer") ? $v : "'$v'";
						$update_str[] = "$k=$v";
					}
					
					$update_str = "SET ".implode(",",$update_str);
					
					if (strstr($pk_field,"::") !== false)
					{
						$pk_field = explode("::",$pk_field);
						$pk_field = $pk_field[1];
					}

					$id = "'".implode("','",explode(",", $id))."'";
					$sql = "UPDATE {$this->table} $update_str WHERE $pk_field IN ($id)";
					$ret = $this->execute_query($sql);

					// return JSON response for update (passing id that was updated)
					if ($ret)
						$res = array("id" => $id, "success" => true);
					else
						$res = array("id" => 0, "success" => false);

					echo json_encode($res);

				break;			
				
				case "del":
					
					// obseleted
					if (strstr($pk_field,"::") !== false)
					{
						$pk_field = explode("::",$pk_field);
						$pk_field = $pk_field[1];
					}
					
					### P ###
					// custom onupdate event execution
					if (!empty($this->events["on_delete"]))
					{
						$func = $this->events["on_delete"][0];
						$obj = $this->events["on_delete"][1];
						$continue = $this->events["on_delete"][2];
						if ($obj)
							call_user_method($func,$obj,array($pk_field => $id));
						else
							call_user_func($func,array($pk_field => $id));
						
						if (!$continue)
							break;
					}
					
					$id = "'".implode("','",explode(",",$id))."'";
					$sql = "DELETE FROM {$this->table} WHERE $pk_field IN ($id)";

					$this->execute_query($sql);
				break;
			}
			
			die;
		}
		
		// apply search conditions (where clause)
		$wh = "";
		
		if (!isset($_REQUEST['_search']))
			$_REQUEST['_search'] = "";
		
		$searchOn = $this->strip($_REQUEST['_search']);
		if($searchOn=='true') 
		{
			$fld = $this->strip($_REQUEST['searchField']);
			
			$cols = array();
			foreach($this->options["colModel"] as $col)
				$cols[] = $col["index"];

			// quick search bar
			if (!$fld)
			{
				$searchstr = $this->strip($_REQUEST['filters']);
				$wh = $this->construct_where($searchstr);
			}
			// search popup form, simple one -- not used anymore
			else
			{
				if(in_array($fld,$cols)) 
				{	
					$fldata = $this->strip($_REQUEST['searchString']);
					$foper = $this->strip($_REQUEST['searchOper']);
					// costruct where
					$wh .= " AND ".$fld;
					switch ($foper) {					
						case "eq":
							if(is_numeric($fldata)) {
								$wh .= " = ".$fldata;
							} else {
								$wh .= " = '".$fldata."'";
							}
							break;
						case "ne":
							if(is_numeric($fldata)) {
								$wh .= " <> ".$fldata;
							} else {
								$wh .= " <> '".$fldata."'";
							}
							break;
						case "lt":
							if(is_numeric($fldata)) {
								$wh .= " < ".$fldata;
							} else {
								$wh .= " < '".$fldata."'";
							}
							break;
						case "le":
							if(is_numeric($fldata)) {
								$wh .= " <= ".$fldata;
							} else {
								$wh .= " <= '".$fldata."'";
							}
							break;
						case "gt":
							if(is_numeric($fldata)) {
								$wh .= " > ".$fldata;
							} else {
								$wh .= " > '".$fldata."'";
							}
							break;
						case "ge":
							if(is_numeric($fldata)) {
								$wh .= " >= ".$fldata;
							} else {
								$wh .= " >= '".$fldata."'";
							}
							break;
						case "ew":
							$wh .= " LIKE '%".$fldata."'";
							break;
						case "en":
							$wh .= " NOT LIKE '%".$fldata."'";
							break;
						case "cn":
							$wh .= " LIKE '%".$fldata."%'";
							break;
						case "nc":
							$wh .= " NOT LIKE '%".$fldata."%'";
							break;
						case "in":
							$wh .= " IN (".$fldata.")";
							break;
						case "ni":
							$wh .= " NOT IN (".$fldata.")";
							break;
						case "bw":
						default:
							$fldata .= "%";
							$wh .= " LIKE '".$fldata."'";
							break;
					}
				}
			}
			// setting to persist where clause in export option
			$_SESSION["jqgrid_filter"] = $wh;
		}
		elseif($searchOn=='false') 
		{
			$_SESSION["jqgrid_filter"] = '';
		}
		
		// generate main json
		if (isset($_GET['jqgrid_page']))
		{
			$page = $_GET['jqgrid_page']; // get the requested page
			$limit = $_GET['rows']; // get how many rows we want to have into the grid
			$sidx = $_GET['sidx']; // get index row - i.e. user click to sort
			$sord = $_GET['sord']; // get the direction
				
			if(!$sidx) $sidx = 1;
			if(!$limit) $limit = 20;

			$sidx = str_replace("::",".",$sidx);
			
			### P ###
			// if export option is requested
			if (isset($_GET["export"]))
			{
				set_time_limit(0);
				$arr = array();

				// export data array (if grid loaded from array)
				if (is_array($this->table))
				{
					$t = $this->table;
					foreach($t[0] as $k => $v)
						$temp[$k] = ucwords($k);

					$arr[] = $temp;
					foreach ($t as $key => $value) {
						$arr[] = $value;
					}
				}
				// if grid loaded from db
				else
				{
					// by default export all
					$export_where = "";
					if ($this->options["export"]["range"] == "filtered")
						$export_where = $_SESSION["jqgrid_filter"];

					$limit_sql= "";
					if ($this->options["export"]["paged"] == "1")
					{
						$offset = $limit*$page - $limit; // do not put $limit*($page - 1)
						if ($offset<0) $offset = 0;
						$limit_sql = "LIMIT $limit OFFSET $offset";
					}
					
					if (($p = stripos($this->select_command,"GROUP BY")) !== false)
					{
						$start = substr($this->select_command,0,$p);
						$end = substr($this->select_command,$p);
						$SQL = $start.$export_where.$end." ORDER BY $sidx $sord $limit_sql";
					}
					else
						$SQL = $this->select_command.$export_where." ORDER BY $sidx $sord $limit_sql";

					// custom export function if needed
					if (!empty($this->events["on_export"]))
					{	
						$func = $this->events["on_export"][0];
						$obj = $this->events["on_export"][1];
						$continue = $this->events["on_export"][2];

						if ($obj)
							call_user_method($func,$obj,array("sql" => $SQL, "grid" => &$this));
						else
							call_user_func($func,array("sql" => $SQL, "grid" => &$this));

						if (!$continue)
							exit(0);						
					}

					$result = $this->execute_query($SQL);

					foreach ($this->options["colModel"] as $c)
					{
						$header[$c["name"]] = $c["title"];
					}

					$arr[] = $header;
					
					if ($this->con)
					{
						$arr = $result->GetRows();
						array_unshift($arr, $header);
					}
					else
					{
						while($row = mysql_fetch_array($result,MYSQL_ASSOC))
						{
							foreach($header as $k=>$v)
								$export_data[$k] = $row[$k];
								
							$arr[] = $export_data;
						}
					}
				}

				$col_widths = array();
				// export only selected columns
				$cols_not_to_export = array();
				$cols_to_export = array();
				if ($this->options["colModel"])
				{
					foreach ($this->options["colModel"] as $c)
					{
						if ($c["export"] === false)
							$cols_not_to_export[] = $c["name"];
						else
						{
							$cols_to_export[] = $c["name"];
							$col_widths[] = (!empty($c["width"]) ? $c["width"] : 'auto');
						}
					}
				}

				if (!empty($cols_to_export))
				{
					$export_arr = array();
					foreach($arr as $arr_item)
					{
						foreach($arr_item as $k=>$i)
						{
							if (!in_array($k, $cols_to_export))
							{
								unset($arr_item[$k]);
							}
						}
						$export_arr[] = $arr_item;
					}	
					$arr = $export_arr;
				}

				// fix for d/m/Y date format in export. strtotime expects m/d/Y
				foreach($this->options["colModel"] as $c)
				{
					foreach ($arr as &$rec)
					{
						// skip header from date format conversion
						if ($rec === $arr[0])
							continue;

						if (!empty($rec[$c["name"]]) && $c["formatter"] == "date")
						{
							$dt = $rec[$c["name"]];

							$js_dt_fmt = $c["formatoptions"]["newformat"];
							$js_dt_fmt = str_replace("yy", "Y", $js_dt_fmt);
							$js_dt_fmt = str_replace("mm", "m", $js_dt_fmt);
							$js_dt_fmt = str_replace("dd", "d", $js_dt_fmt);

							$rec[$c["name"]] = date($js_dt_fmt,strtotime($dt));
						}

						### P ###
						// Replace condition data in pdf export
						$col_name = $c["name"];
						if (isset($c["default"]) && !isset($rec[$col_name]))
							$rec[$col_name] = $c["default"];

						// link data in grid to any given url
						if (!empty($link_c["default"]))
						{
							// replace any param in link e.g. http://domain.com?id={id} given that, there is a $col["name"] = "id" exist
							$rec[$col_name] = $this->replace_row_data($rec,$c["default"]);
						}
						
						// check conditional data
						if (!empty($c["condition"][0]))
						{
							$r = true;

							// replace {} placeholders from connditional data
							$c["condition"][1] = $this->replace_row_data($rec,$c["condition"][1]);
							$c["condition"][2] = $this->replace_row_data($rec,$c["condition"][2]);

							$row = $rec;
							eval("\$r = ".$c["condition"][0].";");
							$rec[$col_name] = ( $r ? $c["condition"][1] : $c["condition"][2]);
							$rec[$col_name] = strip_tags($rec[$col_name]);
						}
					}
				}

				if (!$this->options["export"]["filename"])
					$this->options["export"]["filename"] = $grid_id;
					
				if (!$this->options["export"]["sheetname"])
					$this->options["export"]["sheetname"] = ucwords($grid_id). " Sheet";
					
				if ($this->options["export"]["format"] == "pdf")
				{
					$orientation = $this->options["export"]["orientation"];
					if ($orientation == "landscape")
						$orientation = "L";
					else
						$orientation = "P";

					$paper = $this->options["export"]["paper"];

					// Using opensource TCPdf lib
					// for more options visit http://www.tcpdf.org/examples.php

					require_once('tcpdf/config/lang/eng.php');
					require_once('tcpdf/class.TCPDF.EasyTable.php');

					// create new PDF document
					$pdf = new TCPDF_EasyTable($orientation, PDF_UNIT, $paper, true, 'UTF-8', false);

					// set document information
					$pdf->SetCreator("www.phpgrid.org");
					$pdf->SetAuthor('www.phpgrid.org');
					$pdf->SetTitle('www.phpgrid.org');
					$pdf->SetSubject($this->options["caption"]);
					$pdf->SetKeywords('www.phpgrid.org');

					// remove default header/footer
					$pdf->setPrintHeader(true);
					$pdf->setPrintFooter(true);

					// set default monospaced font
					$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
					$pdf->setFontSubsetting(false);

					//set margins
					$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

					//set auto page breaks
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

					//set image scale factor
					$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

					// set some language dependent data:

					// lines for rtl pdf generation
					if ($this->options["direction"] == "rtl")
					{
						$lg = Array();
						$lg['a_meta_charset'] = 'UTF-8';
						$lg['a_meta_dir'] = 'rtl';
						$lg['a_meta_language'] = 'fa';
						$lg['w_page'] = 'page';
					}
					$pdf->setLanguageArray($lg);

					// To set your custom font
					// $fontname = $pdf->addTTFfont('/path-to-font/DejaVuSans.ttf', 'TrueTypeUnicode', '', 32);
					// set font http://www.tcexam.org/doc/code/classTCPDF.html#afd56e360c43553830d543323e81bc045

					// add a page
					$pdf->AddPage();

				    $pdf->SetY( 10, true );
					
					$pdf->SetFont('helvetica', 'B', 14);
					$pdf->Cell( 0, 15, $this->options["export"]["heading"], 0, 1 );

				    # Table parameters
				    $pdf->SetFont('helvetica', '', 11);
				    $pdf->SetHeaderCellsFontStyle(''); // 'b'
			        $pdf->SetHeaderCellsFillColor(150,150,150);
			        $pdf->SetHeaderCellsFontColor(0,0,0);
			        $pdf->SetFillColor(240,240,240); // for cells background
			        $pdf->SetCellFontColor(0,0,0);

			        // auto set column widths based on grid column width
					$margins = $pdf->GetMargins();
					$pdf_page_width = $pdf->GetPageWidth() - $margins['left'] - $margins['right'];
			        $total_width = 0;
			        foreach ($col_widths as $key => $value) 
			        	$total_width += $value;	

			        $new_widths = array();
			        foreach ($col_widths as $key => $value) 
			        	$new_widths[] = $pdf_page_width * ($value/$total_width);	

			        $pdf->SetCellWidths($new_widths);
			        $pdf->SetCellFillStyle(2);
			        $pdf->SetCellPadding(1);
			        $pdf->SetCellMinimumHeight(null);

					// if customized pdf render is defined, use that
					if (!empty($this->events["on_render_pdf"]))
					{	
						$func = $this->events["on_render_pdf"][0];
						$obj = $this->events["on_render_pdf"][1];
						if ($obj)
							call_user_method($func,$obj,array("pdf" => &$pdf, "data" => &$arr));
						else
							call_user_func($func,array("pdf" => &$pdf, "data" => &$arr));
					}

					$h = $arr[0];
				    array_shift($arr);
				    $pdf->EasyTable($arr,$h);

					//Close and output PDF document
					$pdf->Output($this->options["export"]["filename"].".pdf", 'I');
					die;
				}
				else if ($this->options["export"]["format"] == "csv")
				{
		            header( 'Content-Type: text/csv' );
		            header( 'Content-Disposition: attachment;filename='.$this->options["export"]["filename"].'.csv');		
		            $fp = fopen('php://output', 'w');
		            foreach ($arr as $key => $value) 
		            {
		            	fputcsv($fp, $value);
		            }
		            die;			
				}
				else
				{
					require('export-xls.class.php');
					$xls = new ExportXLS($this->options["export"]["filename"].".xls");
					// if customized pdf render is defined, use that
					if (!empty($this->events["on_render_excel"]))
					{
						$func = $this->events["on_render_excel"][0];
						$obj = $this->events["on_render_excel"][1];
						if ($obj)
							$xls = call_user_method($func,$obj,array("grid" => $this, "xls" => $xls, "data" => $arr));
						else
							$xls = call_user_func($func,array("grid" => $this, "xls" => $xls, "data" => $arr));
					}
					else
					{					
						$xls->addHeader(array($this->options["export"]["sheetname"]));
						$xls->addHeader(array());
						$xls->addHeader($arr[0]);
						for($i=1;$i<count($arr);$i++)
							$xls->addRow($arr[$i]);
					}
					$xls->sendFile();
					die;
				}
			}
			
			// make count query
			if (($p = stripos($this->select_command,"GROUP BY")) !== false)
			{
				$sql_count = preg_replace("/SELECT (.*) FROM/i","SELECT 1 as c FROM",$this->select_command);
				$p = stripos($sql_count,"GROUP BY");
				$start_q = substr($sql_count,0,$p);
				$end_q = substr($sql_count,$p);
				$sql_count = "SELECT count(*) as c FROM ($start_q $wh $end_q) o";
			}
			else
			{
				$sql_count = $this->select_command.$wh;
				$sql_count = "SELECT count(*) as c FROM (".$sql_count.") table_count";
			}
			# print_r($sql_count);
			$result = $this->execute_query($sql_count);

			if ($this->con)
			{
				$row = $result->FetchRow();
			}
			else
			{
				$row = mysql_fetch_array($result,MYSQL_ASSOC);
			}

			$count = $row['c'];
			
			// fix for oracle, alias in capitals
			if (empty($count)) 
				$count = $row['C'];

			if( $count > 0 ) {
				$total_pages = ceil($count/$limit);
			} else {
				$total_pages = 0;
			}

			if ($page > $total_pages) $page=$total_pages;
			$start = $limit*$page - $limit; // do not put $limit*($page - 1)
			if ($start<0) $start = 0;
	
			$responce = new stdClass();
			$responce->page = $page;
			$responce->total = $total_pages;
			$responce->records = $count;

			if (($p = stripos($this->select_command,"GROUP BY")) !== false)
			{
				$start_q = substr($this->select_command,0,$p);
				$end_q = substr($this->select_command,$p);
				$SQL = "$start_q $wh $end_q ORDER BY $sidx $sord LIMIT $limit OFFSET $start";
			}
			else
			{
				$SQL = $this->select_command.$wh." ORDER BY $sidx $sord LIMIT $limit OFFSET $start";
			}

			$SQL = $this->prepare_sql($SQL,$this->db_driver);
			
			$result = $this->execute_query($SQL);

			if ($this->con)
			{
				$rows = $result->GetRows();
				
				// simulate artificial paging for mssql
				if (count($rows) > $limit)
					$rows = array_slice($rows,count($rows) - $limit);
			}
			else
			{
				$rows = array();
				while($row = mysql_fetch_array($result,MYSQL_ASSOC))
					$rows[] = $row;
			}

			### P ###
			// custom on_data_display event execution
			if (!empty($this->events["on_data_display"]))
			{
				$func = $this->events["on_data_display"][0];
				$obj = $this->events["on_data_display"][1];
				$continue = $this->events["on_data_display"][2];
				
				if ($obj)
					call_user_method($func,$obj,array("params" => &$rows));
				else
					call_user_func($func,array("params" => &$rows));
				
				if (!$continue)
					break;
			}
			
			foreach ($rows as $row)	
			{
				$orig_row = $row;
				// apply php level formatter for image url 30.12.10
				foreach($this->options["colModel"] as $c)
				{
					$col_name = $c["name"];
					
					### P ###
					if (isset($c["default"]) && !isset($row[$col_name]))
						$row[$col_name] = $c["default"];

					// link data in grid to any given url
					if (!empty($c["default"]))
					{
						// replace any param in link e.g. http://domain.com?id={id} given that, there is a $col["name"] = "id" exist
						$row[$col_name] = $this->replace_row_data($orig_row,$c["default"]);
					}
					
					// check conditional data
					if (!empty($c["condition"][0]))
					{
						$r = true;

						// replace {} placeholders from connditional data
						$c["condition"][1] = $this->replace_row_data($orig_row,$c["condition"][1]);
						$c["condition"][2] = $this->replace_row_data($orig_row,$c["condition"][2]);

						eval("\$r = ".$c["condition"][0].";");
						$row[$col_name] = ( $r ? $c["condition"][1] : $c["condition"][2]);
					}	

					// check data filter (alternate of grid on_data_display, but for current column)
					if (!empty($c["on_data_display"]))
					{
						$func = $c["on_data_display"][0];
						$obj = $c["on_data_display"][1];
						
						if ($obj)
							$row[$col_name] = call_user_func(array($obj,$func),$row);
						else
							$row[$col_name] = call_user_func($func,$row);
					}
					### P-END ###

					// link data in grid to any given url
					if (!empty($c["link"]))
					{
						// replace any param in link e.g. http://domain.com?id={id} given that, there is a $col["name"] = "id" exist
						// replace_row_data not used due to urlencode work
						foreach($this->options["colModel"] as $link_c)
						{
							$link_row_data = urlencode($orig_row[$link_c["name"]]);
							$c["link"] = str_replace("{".$link_c["name"]."}", $link_row_data, $c["link"]);
						}
						
						if (!empty($c["linkoptions"]))
							$attr = $c["linkoptions"];

						$row[$col_name] = htmlentities($row[$col_name],ENT_QUOTES, "UTF-8");
						
						// if link is made with custom date format
						if (isset($c["formatoptions"]["newformat"]))
						{
							$js_dt_fmt = $c["formatoptions"]["newformat"];
							$js_dt_fmt = str_replace("yy", "Y", $js_dt_fmt);
							$js_dt_fmt = str_replace("mm", "m", $js_dt_fmt);
							$js_dt_fmt = str_replace("dd", "d", $js_dt_fmt);
							$row[$col_name] = date($c["formatoptions"]["newformat"],strtotime($row[$col_name]));
						}

						$row[$col_name] = "<a $attr href='{$c["link"]}'>{$row[$col_name]}</a>";
					}

					// render row data as "src" value of <img> tag
					if (isset($c["formatter"]) && $c["formatter"] == "image")
					{
						$attr = array();
						foreach($c["formatoptions"] as $k=>$v)
							$attr[] = "$k='$v'";
						
						$attr = implode(" ",$attr);
						$row[$col_name] = "<img $attr src='".$row[$col_name] ."'>";
					}
						
					// show masked data in password
					if (isset($c["formatter"]) && $c["formatter"] == "password")
						$row[$col_name] = "*****";			
				}

				foreach($row as $k=>$r)
					$row[$k] = stripslashes($row[$k]);

				$responce->rows[] = $row;
			}
			
			echo json_encode($responce);
			die;
		}		
		
		### P ###
		// if loading from array
		if (is_array($this->table))
		{
			$this->options["data"] = json_encode($this->table);
			$this->options["datatype"] = "local";	
			$this->actions["rowactions"] = false;		
			$this->actions["add"] = false;		
			$this->actions["edit"] = false;		
			$this->actions["delete"] = false;		
		}

		// few overides - pagination fixes
		$this->options["pager"] = '#'.$grid_id."_pager";
		$this->options["jsonReader"] = array("repeatitems" => false, "id" => "0");

		// allow/disallow edit,del operations
		if ( ($this->actions["edit"] === false && $this->actions["delete"] === false) || $this->options["cellEdit"] === true)
			$this->actions["rowactions"] = false;
			
		if ($this->actions["rowactions"] !== false)
		{
			// CRUD operation column
			$f = false;
			$defined = false;
			foreach($this->options["colModel"] as &$c)
			{
				if ($c["name"] == "act")
				{
					$defined = &$c;
				}
					
				if (!empty($c["width"]))
				{
					$f = true;
				}
			}
			
			// width adjustment for row actions column
			if ($f)
				$action_column = array("name"=>"act", "align"=>"center", "index"=>"act", "width"=>"40", "sortable"=>false, "search"=>false, "viewable"=>false);
			else
				$action_column = array("name"=>"act", "align"=>"center", "index"=>"act", "width"=>"60", "sortable"=>false, "search"=>false, "viewable"=>false);

			if (!$defined)
			{
				$this->options["colNames"][] = "Actions";
				$this->options["colModel"][] = $action_column;
			}
			else
				$defined = array_merge($action_column,$defined);
		}		

		// simulate field access right options
		$str_add_form = '';
		$str_edit_form = '';
		$str_delete_form = '';
		foreach($this->options["colModel"] as &$c)
		{
			if (!empty($c["show"]))
			{
				if ($c["show"]["list"] === false)
					$c["hidden"] = true;
				else
					$c["hidden"] = false;

				if ($c["show"]["edit"] === false)
				{
					$str_edit_form .= '$("#tr_'.$c["index"].'",formid).remove();';
				}
				else
					$str_edit_form .= '$("#tr_'.$c["index"].'",formid).show();';

				if ($c["show"]["add"] === false)
					$str_add_form .= '$("#tr_'.$c["index"].'",formid).remove();';
				else
					$str_add_form .= '$("#tr_'.$c["index"].'",formid).show();';

				unset($c["show"]);
			}
		}

		// set before show form events

		if (!empty($this->internal["add_options"]["beforeShowForm"]))
			$str_add_form .= $this->internal["add_options"]["beforeShowForm"];

		if (!empty($this->internal["edit_options"]["beforeShowForm"]))
			$str_edit_form .= $this->internal["edit_options"]["beforeShowForm"];

		if (!empty($this->internal["delete_options"]["beforeShowForm"]))
			$str_delete_form .= $this->internal["delete_options"]["beforeShowForm"];

		$this->options["add_options"]["beforeShowForm"] = 'function(formid) { '.$str_add_form.' }';
		$this->options["edit_options"]["beforeShowForm"] = 'function(formid) { '.$str_edit_form.' }';
		$this->options["delete_options"]["beforeShowForm"] = 'function(formid) { '.$str_delete_form.' }';

		$out = json_encode_jsfunc($this->options);
		$out = substr($out,0,strlen($out)-1);

		// create Edit/Delete - Save/Cancel column in grid
		if ($this->actions["rowactions"] !== false)
		{
			$act_links = array();
			if ($this->actions["edit"] !== false)
				$act_links[] = "<a title=\"Edit this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#$grid_id\').editRow(\''+cl+'\',true); jQuery(this).parent().hide(); jQuery(this).parent().next().show(); \">Edit</a>";

			### P ###
			if ($this->actions["clone"] === true)
				$act_links[] = "<a title=\"Clone this row\" href=\"javascript:void(0);\" onclick=\"clone_row(\'$grid_id\',\''+cl+'\'); \">Clone</a>";

			if ($this->actions["delete"] !== false)
				$act_links[] = "<a title=\"Delete this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#$grid_id\').delGridRow(\''+cl+'\'); \">Delete</a>";

			$act_links = implode(" | ", $act_links);

			$out .= ",'gridComplete': function(){
						var ids = jQuery('#$grid_id').jqGrid('getDataIDs');
						for(var i=0;i < ids.length;i++){
							var cl = ids[i];
							
							be = '$act_links'; 
							
							se = ' <a title=\"Save this row\" href=\"javascript:void(0);\" onclick=\"if (jQuery(\'#$grid_id\').saveRow(\''+cl+'\')) { jQuery(this).parent().hide(); jQuery(this).parent().prev().show(); }\">Save</a>'; 
							ce = ' | <a title=\"Restore this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#$grid_id\').restoreRow(\''+cl+'\'); jQuery(this).parent().hide(); jQuery(this).parent().prev().show();\">Cancel</a>'; 
							
							if (ids[i] == 'new_row')
							{
								se = ' <a title=\"Save this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#{$grid_id}_ilsave\').click(); \">Save</a>'; 
								ce = ' | <a title=\"Restore this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#{$grid_id}_ilcancel\').click(); jQuery(this).parent().hide(); jQuery(this).parent().prev().show();\">Cancel</a>'; 
								jQuery('#$grid_id').jqGrid('setRowData',ids[i],{act:'<span style=display:none id=\"edit_row_{$grid_id}_'+cl+'\">'+be+'</span>'+'<span id=\"save_row_{$grid_id}_'+cl+'\">'+se+ce+'</span>'});
							}
							else
								jQuery('#$grid_id').jqGrid('setRowData',ids[i],{act:'<span id=\"edit_row_{$grid_id}_'+cl+'\">'+be+'</span>'+'<span style=display:none id=\"save_row_{$grid_id}_'+cl+'\">'+se+ce+'</span>'});
						}	
					}";

			/*
			// theme buttons -- not looking good
			$out .= ",'gridComplete': function(){
						var ids = jQuery('#$grid_id').jqGrid('getDataIDs');
						for(var i=0;i < ids.length;i++){
							var cl = ids[i];
							be = ' <a style=\"padding:0 0.5em;padding-left:1.6em;font-weight:normal;\" class=\"fm-button fm-button-icon-left ui-state-default ui-corner-all\" title=\"Edit this row\" onclick=\"jQuery(\'#$grid_id\').editRow('+cl+',true); jQuery(this).parent().hide(); jQuery(this).parent().next().show(); \">Edit <span class=\"ui-icon ui-icon-pencil\"></span></a>'; 
							de = ' <a style=\"padding:0 0.5em;padding-left:1.6em;font-weight:normal;\" class=\"fm-button fm-button-icon-left ui-state-default ui-corner-all\" title=\"Delete this row\" onclick=\"jQuery(\'#$grid_id\').delRowData('+cl+'); \">Delete <span class=\"ui-icon ui-icon-close\"></span></a>';

							se = ' <a style=\"padding:0 0.5em;padding-left:1.6em;font-weight:normal;\" class=\"fm-button fm-button-icon-left ui-state-default ui-corner-all\" title=\"Save this row\" onclick=\"jQuery(\'#$grid_id\').saveRow('+cl+'); jQuery(this).parent().hide(); jQuery(this).parent().prev().show();\">Save <span class=\"ui-icon ui-icon-disk\"></span></a>'; 
							ce = ' <a style=\"padding:0 0.5em;padding-left:1.6em;font-weight:normal;\" class=\"fm-button fm-button-icon-left ui-state-default ui-corner-all\" title=\"Restore this row\" href=\"javascript:void(0);\" onclick=\"jQuery(\'#$grid_id\').restoreRow('+cl+'); jQuery(this).parent().hide(); jQuery(this).parent().prev().show();\">Cancel <span class=\"ui-icon ui-icon-cancel\"></span></a>'; 
							
							jQuery('#$grid_id').jqGrid('setRowData',ids[i],{act:'<div style=\"white-space:nowrap;float:left\" id=\"edit_row_'+cl+'\">'+be+de+'</div>'+'<div style=\"white-space:nowrap;float:left;display:none;\" id=\"save_row_'+cl+'\">'+se+ce+'</div>'});
						}	
					}";
			*/
		}					
		
		// double click editing option
		if ($this->actions["rowactions"] !== false && $this->actions["edit"] !== false && $this->options["cellEdit"] !== true)
		{
			if ($this->options["reloadedit"] === true)
				$reload_after_edit = "jQuery('#$grid_id').jqGrid().trigger('reloadGrid',[{jqgrid_page:1}]);";

			$out .= ",'ondblClickRow': function(id) 
						{
							if(id && id!==lastSel)
							{ 
								jQuery('#$grid_id').restoreRow(lastSel); 
								
								// disabled previously edit icons
								jQuery('#edit_row_{$grid_id}_'+lastSel).show();
								jQuery('#save_row_{$grid_id}_'+lastSel).hide();								
								
								lastSel=id; 								
							}
							
							jQuery('#$grid_id').editRow(id, true, function(){}, function()
																				{
																					jQuery('#edit_row_{$grid_id}_'+id).show();
																					jQuery('#save_row_{$grid_id}_'+id).hide();
																					return true;
																				},null,null,
																				function()
																				{
																					// force reload grid after inline save
																					$reload_after_edit
																				},null,
																				function()
																				{
																					jQuery('#edit_row_{$grid_id}_'+id).show();
																					jQuery('#save_row_{$grid_id}_'+id).hide();
																					return true;
																				}
														); 
							
							jQuery('#edit_row_{$grid_id}_'+id).hide();
							jQuery('#save_row_{$grid_id}_'+id).show();
						}";
		}
		
		### P ###
		// if subgrid is there, enable subgrid feature
		if (isset($this->options["subgridurl"]) && $this->options["subgridurl"] != '') 
		{
			// we pass two parameters
			// subgrid_id is a id of the div tag created within a table
			// the row_id is the id of the row
			// If we want to pass additional parameters to the url we can use
			// the method getRowData(row_id) - which returns associative array in type name-value
			// here we can easy construct the following
					
			$pass_params = "false";
			if (!empty($this->options["subgridparams"]))
				$pass_params = "true";
				
			$out .= ",'subGridRowExpanded': function(subgridid, id) 
											{ 
												var data = {subgrid:subgridid, rowid:id};
												
												if('$pass_params' == 'true') {
													var anm= '".$this->options["subgridparams"]."';
													anm = anm.split(',');
													var rd = jQuery('#".$grid_id."').jqGrid('getRowData', id);
													if(rd) {
														for(var i=0; i<anm.length; i++) {
															if(rd[anm[i]]) {
																data[anm[i]] = rd[anm[i]];
															}
														}
													}
												}
												jQuery('#'+jQuery.jgrid.jqID(subgridid)).load('".$this->options["subgridurl"]."',data);
											}";				
		}

		// on error
		$out .= ",'loadError': function(xhr,status, err) { 
					try 
					{
						jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class=\"ui-state-error\">'+ xhr.responseText +'</div>', 
													jQuery.jgrid.edit.bClose,{buttonalign:'right'});
					} 
					catch(e) { alert(xhr.responseText);}
				}
				";

		// on row selection operation
		$out .= ",'onSelectRow': function(ids) { ";

				### P ###
				if (isset($this->options["detail_grid_id"]) && $this->options["detail_grid_id"] != '') 
				{
					$detail_grid_id	= $this->options["detail_grid_id"];
					$d_grids = explode(",", $detail_grid_id);

					foreach($d_grids as $detail_grid_id) 
					{
						$detail_url= "?grid_id=". $detail_grid_id;

						$out .= "
		
						var data = '';
						if ('{$this->options["subgridparams"]}'.length > 0)
						{
							var anm = '".$this->options["subgridparams"]."';
							anm = anm.split(',');
							var rd = jQuery('#".$grid_id."').jqGrid('getRowData', ids);
							if(rd) {
								for(var i=0; i<anm.length; i++) {
									if(rd[anm[i]]) {
										data += '&' + anm[i] + '=' + rd[anm[i]];
									}
								}
							}
						}	
							
						if(ids == null) 
						{
							ids=0;
							if(jQuery('#".$detail_grid_id."').jqGrid('getGridParam','records') >0 )
							{
								jQuery('#".$detail_grid_id."').jqGrid('setGridParam',{url:'".$detail_url."&rowid='+ids+data,editurl:'".$detail_url."&rowid='+ids,jqgrid_page:1});
								jQuery('#".$detail_grid_id."').trigger('reloadGrid',[{jqgrid_page:1}]);
							}
						} 
						else 
						{
							jQuery('#".$detail_grid_id."').jqGrid('setGridParam',{url:'".$detail_url."&rowid='+ids+data,editurl:'".$detail_url."&rowid='+ids,jqgrid_page:1});
							jQuery('#".$detail_grid_id."').trigger('reloadGrid',[{jqgrid_page:1}]);			
						}
						";
					}
				};

				### P ###
				if (!empty($this->events["js_on_select_row"])) 
				{
					$out .= "if (typeof({$this->events["js_on_select_row"]}) != 'undefined') {$this->events["js_on_select_row"]}(ids);";
				}	
		// closing of select row events
		$out .= "}";

		// on load complete operation
		$out .= ",'loadComplete': function(ids) {";

				if (isset($this->options["detail_grid_id"]) && $this->options["detail_grid_id"] != '') 
				{
					$detail_grid_id	= $this->options["detail_grid_id"];
					$d_grids = explode(",", $detail_grid_id);

					foreach($d_grids as $detail_grid_id) 
					{
						$detail_url= "?grid_id=". $detail_grid_id;

						$out .= "
								jQuery('#".$detail_grid_id."').jqGrid('setGridParam',{url:'".$detail_url."&rowid=',editurl:'".$detail_url."&rowid=',jqgrid_page:1});
								jQuery('#".$detail_grid_id."').trigger('reloadGrid',[{jqgrid_page:1}]);";
					}

				}		

		$out .= "if(ids.rows) jQuery.each(ids.rows,function(i){
					var rows = jQuery('#$grid_id tr').length - jQuery('#$grid_id').jqGrid('getGridParam', 'rowNum') - 1;
					i = i + rows;
					";
			
				### P ###
				if (count($this->conditional_css))
				{
					foreach ($this->conditional_css as $value) 
					{
						if ($value["op"] == "cn")
						{
							$out .= "
								if (this.{$value[column]}.toLowerCase().indexOf('{$value[value]}'.toLowerCase()) != -1)
							 	{
							 		jQuery('#$grid_id tr.jqgrow:eq('+i+')').css('background','inherit').css({{$value[css]}});
							 	}";
						}
						else if ($value["op"] == "eq")
						{
							$out .= "
								if (this.{$value[column]}.toLowerCase() == '{$value[value]}'.toLowerCase())
							 	{
							 		jQuery('#$grid_id tr.jqgrow:eq('+i+')').css('background','inherit').css({{$value[css]}});
							 	}";
						}
						else if ($value["op"] == "<" || $value["op"] == "<=" || $value["op"] == ">" || $value["op"] == ">=" || $value["op"] == "!=")
						{
							$out .= "
								if (this.{$value[column]} {$value["op"]} {$value[value]})
							 	{
							 		jQuery('#$grid_id tr.jqgrow:eq('+i+')').css('background','inherit').css({{$value[css]}});
							 	}";
						}
						// column formatting
						else if (empty($value["op"]) && !empty($value["column"]) && !empty($value["css"]))
						{
							$out .= "
							 	{
							 		if (jQuery.browser.msie)
							 			jQuery('#$grid_id td[aria-describedby={$grid_id}_{$value["column"]}]').css('background','inherit').css({{$value[css]}});
							 		else
							 			jQuery('#$grid_id td[aria-describedby={$grid_id}_{$value["column"]}]').removeClass('.ui-widget-content').css({{$value[css]}});
							 	}";							
						}
					}
				}

		$out .= "});";

		### P ###
		if (!empty($this->events["js_on_load_complete"])) 
		{
			$out .= "if (typeof({$this->events["js_on_load_complete"]}) != 'undefined') {$this->events["js_on_load_complete"]}(ids);";
		}

		// closing of load complete events
		$out .= "}";
		
		// closing of param list
		$out .= "}";

		// Navigational grid params
		$this->navgrid["param"]["edit"] = ($this->actions["edit"] === false) ? false:true;
		$this->navgrid["param"]["add"] = ($this->actions["add"] === false) ? false:true;
		$this->navgrid["param"]["del"] = ($this->actions["delete"] === false) ? false:true;
		$this->navgrid["param"]["view"] = ($this->actions["view"] === true) ? true:false;
		### P ### -- turn false
		$this->navgrid["param"]["search"] = ($this->actions["search"] === false) ? false : true;

		// Generate HTML/JS code
		ob_start();
		?>
			<table id="<?php echo $grid_id?>"></table> 
			<div id="<?php echo $grid_id."_pager"?>"></div> 
			<script>
			var phpgrid = jQuery("#<?php echo $grid_id?>");
			var phpgrid_pager = jQuery("#<?php echo $grid_id."_pager"?>");
			var fx_ajax_file_upload;
			var fx_replace_upload;

			jQuery(document).ready(function(){
				<?php echo $this->render_js($grid_id,$out);?>
			});	

			function phpgrid_bulk_update()
			{
				var selr = jQuery('#<?php echo $grid_id?>').jqGrid('getGridParam','selarrrow'); // array of id's of the selected rows when multiselect options is true. Empty array if not selection 
				var str = selr[0];
				for (var x=1;x<selr.length;x++)
				{
					str += ',' + selr[x];
				}

				var dt = prompt('Enter new value for: '+jQuery('#bulk_update').val());

				// call ajax to update date in db
				var request = {};
				request['oper'] = 'edit';
				request['id'] = str;
				request[jQuery('#bulk_update').val()] = dt;

				jQuery.ajax({
					url: "<?php echo $this->options["url"]?>",
					dataType: 'json',
					data: request,
					type: 'POST',
					error: function(res, status) {
						alert(res.status+' : '+res.statusText+'. Status: '+status);
					},
					success: function( data ) {
						alert( data );
					}
				});

				// reload grid for data changes
				jQuery('#<?php echo $grid_id?>').jqGrid().trigger('reloadGrid',[{jqgrid_page:1}]);
			}

			</script>	
		<?php
		return ob_get_clean();
	}
	
	/**
	 * JS code related to grid rendering
	 */
	function render_js($grid_id,$out)
	{
	?>
		var lastSel;
		clone_row = function (grid,id) 
		{
			myData = {};
			myData.id = id;
			myData.oper = 'clone';
			jQuery.ajax({
				url: "<?php echo $this->options["url"]?>",
				dataType: "json",
				data: myData,
				type: "POST",
				error: function(res, status) {
					alert(res.status+" : "+res.statusText+". Status: "+status);
				},
				success: function( data ) {
				}
			});
			jQuery("#"+grid).jqGrid().trigger('reloadGrid',[{jqgrid_page:1}]);
		}

		var extra_opts = {};

		<?php ### P ### ?>
		extra_opts = (typeof(opts) == 'undefined') ? {} : opts;

		var grid_<?php echo $grid_id?> = jQuery("#<?php echo $grid_id?>").jqGrid( jQuery.extend(<?php echo $out?>, extra_opts ) );
		
		jQuery("#<?php echo $grid_id?>").jqGrid('navGrid','#<?php echo $grid_id."_pager"?>',
				<?php echo json_encode_jsfunc($this->navgrid["param"])?>,
				<?php echo json_encode_jsfunc($this->options["edit_options"])?>,
				<?php echo json_encode_jsfunc($this->options["add_options"])?>,
				<?php echo json_encode_jsfunc($this->options["delete_options"])?>,
				<?php ### P ### remove above , for IE ?>
				{
					multipleSearch:<?php echo ($this->actions["search"] == "advance")?"true":"false"?>, 
					sopt:['eq','ne','lt','le','gt','ge','bw','bn','in','ni','ew','en','cn','nc','nu','nn']
				}
				);	
		
		// Set grouping header using callGridMethod
		<?php if (!empty($this->group_header)) { ?>
		jQuery("#<?php echo $grid_id?>").jqGrid("setGroupHeaders", <?php echo json_encode_jsfunc($this->group_header)?>);	
		<?php } ?>

		<?php ### P ### ?>		
		<?php if ($this->actions["inlineadd"] !== false) { ?>
		jQuery('#<?php echo $grid_id?>').jqGrid('inlineNav','#<?php echo $grid_id."_pager"?>',{"addtext":"Inline","edit":false,"save":true,"cancel":true,
		"addParams":{
						"aftersavefunc":function (id, res)
						{
							// set returned pk in new row of grid
							res = res.responseText.split("#");
							try {
								$(this).jqGrid('setCell', id, res[0], res[1]);
								$("#"+id, "#"+this.p.id).removeClass("jqgrid-new-row").attr("id",res[1] );
							} catch (asr) {}
							
							// but reload grid, to work properly
							jQuery('#<?php echo $grid_id?>').trigger("reloadGrid",[{jqgrid_page:1}]);
						}
		}
		,"editParams":{	
							"aftersavefunc":function (id, res)
							{
								// set returned pk in new row of grid
								res = res.responseText.split("#");
								try {
									$(this).jqGrid('setCell', id, res[0], res[1]);
									$("#"+id, "#"+this.p.id).removeClass("jqgrid-new-row").attr("id",res[1] );
								} catch (asr) {}

								// but reload grid, to work properly			
								jQuery('#<?php echo $grid_id?>').trigger("reloadGrid",[{jqgrid_page:1}]);
							},
							"errorfunc": function(id,res)
							{
								jQuery('#<?php echo $grid_id?>').trigger("reloadGrid",[{jqgrid_page:1}]);
							}
		}});
		<?php } ?>
			
		<?php if ($this->actions["autofilter"] !== false) { ?>
		// auto filter with contains search
		jQuery("#<?php echo $grid_id?>").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, defaultSearch:'cn'}); 
		// jQuery("#<?php echo $grid_id?>").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false}); 
		<?php } ?>

		<?php if ($this->actions["showhidecolumns"] !== false) { ?>
		// show/hide columns
		jQuery("#<?php echo $grid_id?>").jqGrid('navButtonAdd',"#<?php echo $grid_id."_pager"?>",{caption:"Columns",title:"Hide/Show Columns", buttonicon :'ui-icon-note',
			onClickButton:function(){
				jQuery("#<?php echo $grid_id?>").jqGrid('setColumns'); 
			} 
		});
		<?php } ?>

		<?php if ($this->actions["export"] === true || $this->actions["export_excel"] === true || $this->actions["export_pdf"] === true || $this->actions["export_csv"] === true) {
		$order_by = "&sidx=".$this->options["sortname"]."&sord=".$this->options["sortorder"]."&rows=".$this->options["rowNum"];
		} ?> 

		<?php ### P ### ?>
		<?php if ($this->actions["export"] === true) { ?>
		// Export to what is defined in file
		jQuery("#<?php echo $grid_id?>").jqGrid('navButtonAdd',"#<?php echo $grid_id."_pager"?>",{caption:"Export",title:"Export", buttonicon :'ui-icon-extlink',
			onClickButton:function(){
				if ("<?php echo $this->options["url"]?>".indexOf("?") != -1)
					location.href = "<?php echo $this->options["url"]?>" + "&export=1&jqgrid_page=1<?php echo $order_by?>";
				else
					location.href = "<?php echo $this->options["url"]?>" + "?export=1&jqgrid_page=1<?php echo $order_by?>";
			} 
		});
		<?php } ?>
			
		<?php ### P ### ?>
		<?php if (isset($this->actions["export_excel"]) && $this->actions["export_excel"] === true) { ?>
		// Export to excel
		jQuery("#<?php echo $grid_id?>").jqGrid('navButtonAdd',"#<?php echo $grid_id."_pager"?>",{caption:"Excel",title:"Excel", buttonicon :'ui-icon-extlink',
			onClickButton:function(){
				if ("<?php echo $this->options["url"]?>".indexOf("?") != -1)
					location.href = "<?php echo $this->options["url"]?>" + "&export=1&jqgrid_page=1&export_type=excel<?php echo $order_by?>";
				else
					location.href = "<?php echo $this->options["url"]?>" + "?export=1&jqgrid_page=1&export_type=excel<?php echo $order_by?>";
			} 
		});
		<?php } ?>
			
		<?php ### P ### ?>
		<?php if (isset($this->actions["export_pdf"]) && $this->actions["export_pdf"] === true) { ?>
		// Export to pdf
		jQuery("#<?php echo $grid_id?>").jqGrid('navButtonAdd',"#<?php echo $grid_id."_pager"?>",{caption:"PDF",title:"PDF", buttonicon :'ui-icon-extlink',
			onClickButton:function(){
				if ("<?php echo $this->options["url"]?>".indexOf("?") != -1)
					location.href = "<?php echo $this->options["url"]?>" + "&export=1&jqgrid_page=1&export_type=pdf<?php echo $order_by?>";
				else
					location.href = "<?php echo $this->options["url"]?>" + "?export=1&jqgrid_page=1&export_type=pdf<?php echo $order_by?>";
			} 
		});		
		<?php } ?>	

		<?php ### P ### ?>
		<?php if (isset($this->actions["export_csv"]) && $this->actions["export_csv"] === true) { ?>
		// Export to csv
		jQuery("#<?php echo $grid_id?>").jqGrid('navButtonAdd',"#<?php echo $grid_id."_pager"?>",{caption:"CSV",title:"CSV", buttonicon :'ui-icon-extlink',
			onClickButton:function(){
				if ("<?php echo $this->options["url"]?>".indexOf("?") != -1)
					location.href = "<?php echo $this->options["url"]?>" + "&export=1&jqgrid_page=1&export_type=csv<?php echo $order_by?>";
				else
					location.href = "<?php echo $this->options["url"]?>" + "?export=1&jqgrid_page=1&export_type=csv<?php echo $order_by?>";
			} 
		});		
		<?php } ?>

		<?php ### P ### ?>
		<?php if (isset($this->actions["clone"]) && $this->actions["clone"] === true) { ?>
		// Clone button
		jQuery("#<?php echo $grid_id?>").jqGrid('navButtonAdd',"#<?php echo $grid_id."_pager"?>",{caption:"",title:"Clone", buttonicon :'ui-icon-copy',
			onClickButton:function(){
				var selr = jQuery("#<?php echo $grid_id?>").jqGrid('getGridParam','selrow');
				if (!selr)
				{
					var alertIDs = {themodal:'alertmod',modalhead:'alerthd',modalcontent:'alertcnt'};
					if ($("#"+alertIDs.themodal).html() === null) {
					    $.jgrid.createModal(alertIDs,"<div>"+$.jgrid.nav.alerttext+
					        "</div><span tabindex='0'><span tabindex='-1' id='jqg_alrt'></span></span>",
					        {gbox:"#gbox_"+$.jgrid.jqID(this.p.id),jqModal:true,drag:true,resize:true,
					        caption:$.jgrid.nav.alertcap,
					        top:100,left:100,width:200,height: 'auto',closeOnEscape:true,
					        zIndex: null},"","",true);
					}
					$.jgrid.viewModal("#"+alertIDs.themodal,
					    {gbox:"#gbox_"+$.jgrid.jqID(this.p.id),jqm:true});
					$("#jqg_alrt").focus();
					return;
				}

				clone_row("<?php echo $grid_id?>",selr);
			} 
		});		
		<?php } ?>

		function link_date_picker(el,fmt,toolbar)
		{
			toolbar = toolbar || 0;
			setTimeout(function(){
				if(jQuery.ui) 
				{ 
					if(jQuery.ui.datepicker) 
					{ 
						if (toolbar == 0) jQuery(el).after('<button>Calendar</button>').next().button({icons:{primary: 'ui-icon-calendar'}, text:false}).css({'font-size':'69%'}).click(function(e){jQuery(el).datepicker('show');return false;});
						jQuery(el).datepicker({
												"disabled":false,
												"dateFormat":fmt,
												"onSelect": function (dateText, inst) 
															{
																if (toolbar)
																{
											                    	setTimeout(function () {
											                        jQuery("#<?php echo $grid_id?>")[0].triggerToolbar();
											                    	}, 50);
																}
										                	}
        									});
						jQuery('.ui-datepicker').css({'font-size':'69%'}); 
					} 
				}
			},300);
		}				

		function link_datetime_picker(el,fmt)
		{
			setTimeout(function(){
				if(jQuery.ui) 
				{ 
					if(jQuery.ui.datepicker) 
					{
						jQuery(el).after('<button>Calendar</button>').next().button({icons:{primary: 'ui-icon-calendar'}, text:false}).css({'font-size':'69%'}).click(function(e){jQuery(el).datetimepicker('show');return false;});
						jQuery(el).datetimepicker({"disabled":false,"dateFormat":fmt});
						jQuery('.ui-datepicker').css({'font-size':'69%'});
					}
				}
			},100);
		}	

		<?php ### P ### ?>
		function link_editor(el)
		{
			setTimeout(function(){
				var editor = CKEDITOR.replace( el, {
					on: {
						change: function(){ jQuery(el).val(editor.getData()); }
					},
					height: '100px'
				});
			},100);
		}

		<?php ### P ### ?>
		function link_upload(el,field)
		{
			setTimeout(function(){

				fx_replace_upload = function(el)
				{
					jQuery(el).parent().append("<input id='"+field+"_file' size='10' name='"+field+"' type='file' onchange='jQuery(\"#"+field+"\").remove(); jQuery(this).attr(\"id\",\""+field+"\"); fx_ajax_file_upload(\""+field+"\",\"<?php echo $this->options["url"]?>\");' />");
					jQuery(el).parent().children("span").remove();
					jQuery(el).parent().children("input[type=button]").remove();
				}

				if(jQuery(el).val() != '')
				{
					jQuery(el).parent().append("<span id='"+field+"_name'>"+jQuery(el).val().substring(jQuery(el).val().lastIndexOf('/')+1)+"</span> ");
					jQuery(el).parent().append("<input type='button' value='Delete' onclick='jQuery(\"#"+field+"\").val(\"\"); fx_replace_upload(\"#"+field+"\");' />");
					jQuery(el).hide();
				}
				else
				{
					jQuery(el).replaceWith("<input id='"+field+"' size='10' name='"+field+"' type='file' onchange='fx_ajax_file_upload(\""+field+"\",\"<?php echo $this->options["url"]?>\");' />");
				}

			},100);
		}

		<?php ### P ### ?>
		function link_autocomplete(el,update_field)
		{
			setTimeout(function()
			{
				if(jQuery.ui) 
				{ 
					if(jQuery.ui.autocomplete)
					{
						jQuery(el).autocomplete({	"appendTo":"body","disabled":false,"delay":300,
													"minLength":1,
													"source":function (request, response)
															{
																request.element = el.name;
																request.oper = 'autocomplete';
																jQuery.ajax({
																	url: "<?php echo $this->options["url"]?>",
																	dataType: "json",
																	data: request,
																	type: "POST",
																	error: function(res, status) {
																		alert(res.status+" : "+res.statusText+". Status: "+status);
																	},
																	success: function( data ) {
																		response( data );
																	}
																});
															},
													"select":function (event, ui)
															{
																// change function to set target value
																var ival;
																if(ui.item) {
																	ival = ui.item.id || ui.item.value;
																}
																if(ival) {
																	jQuery("input[name='"+update_field+"'].editable, input[id='"+update_field+"']").val(ival);
																} else {
																	jQuery("input[name='"+update_field+"']").val("");
																	if("1" == "true"){
																	this.value = "";
																	}
																}
															}
												});

						jQuery(el).autocomplete('widget').css('font-size','11px');

					} // if jQuery.ui.autocomplete
				} // if jQuery.ui
			},200); // setTimeout
		} // link_autocomplete

		<?php ### P ### ?>
		<?php if ($this->require_upload_ajax) { ?>
		
		fx_ajax_file_upload = function (field,upload_url)
		{
			//starting setting some animation when the ajax starts and completes
			if (typeof(document.getElementById(field+'_upload')) != "undefined")
				jQuery("input#"+field).parent().append('<span id="'+field+'_upload">&nbsp;&nbsp;Uploading...</span>');
			else
				jQuery("#"+field+"_upload").html("Uploading...");
			
			/*
			prepareing ajax file upload
			url: the url of script file handling the uploaded files
						fileElementId: the file type of input element id and it will be the index of  $_FILES Array()
			dataType: it support json, xml
			secureuri:use secure protocol
			success: call back function when the ajax complete
			error: callback function when the ajax failed
			*/
			jQuery.ajaxFileUpload
			(
				{
					url:upload_url, 
					secureuri:false,
					fileElementId:field,
					dataType: 'json',
					data: {"field":field},
					success: function (data, status)
					{
						if(typeof(data.error) != 'undefined')
						{
							if(data.error != '')
							{
								//alert(data.error);
								jQuery("#"+field+"_upload").html(data.error);
							}else
							{
								//alert(data.msg);
								jQuery("#"+field+"_upload").html(data.msg.substring(data.msg.lastIndexOf('/')+1) + " (Uploaded)");

								var o = jQuery("input#"+field);
								$("<input type='text' />").attr({ 	name: o.attr("name"), 
																	value: data.msg,
																	class: "FormElement ui-widget-content ui-corner-all",
																	role: "textbox",
																	id: o.attr("id")
																	 }).insertBefore(o).hide();
								o.remove();

							}
						}
					},
					error: function (data, status, e)
					{
						alert(e);
					}
				}
			)
			return false;
		}  	
		<?php } ?>
		
		<?php ### P ### ?>
		<?php if (isset($this->options["toolbar"]) && $this->options["toolbar"] != "bottom") { ?>
			// Toolbar position button
			
			<?php if ($this->options["toolbar"] == "top") { ?>
				jQuery('#<?php echo $grid_id?>_pager').insertBefore('#<?php echo $grid_id?>_toppager');
			<?php } else if ($this->options["toolbar"] == "both") { ?>
				jQuery('#<?php echo $grid_id?>_pager').clone(true).insertBefore('#<?php echo $grid_id?>_toppager').attr('id','_toppager');
			<?php } ?>

			jQuery('#<?php echo $grid_id?>_pager').removeClass("ui-jqgrid-pager");
			jQuery('#<?php echo $grid_id?>_pager').addClass("ui-jqgrid-toppager");
			jQuery('#<?php echo $grid_id?>_toppager').remove();
			jQuery('#_toppager').attr('id','<?php echo $grid_id?>_toppager');

		<?php } ?>

		<?php if ($this->options["resizable"] === true) { ?>
		$(window).bind("resize", function () {
		    var oldWidth = jQuery("#<?php echo $grid_id?>").jqGrid("getGridParam", "width"),
		        newWidth = $(window).width() - 30;

		    if (oldWidth !== newWidth) {
		        jQuery("#<?php echo $grid_id?>").jqGrid("setGridWidth", newWidth);
		    }
		}).trigger("resize");
		jQuery("#<?php echo $grid_id?>").jqGrid('gridResize',{});
		<?php } ?>

		<?php ### P ### ?>
		jQuery("#<?php echo $grid_id?>").jqGrid('setFrozenColumns');		
	<?php
	}

	function prepare_sql($sql,$db)
	{
		### P ###
		if (strpos($db,"mssql") !== false)
		{
			$sql = preg_replace("/SELECT (.*) LIMIT ([0-9]+) OFFSET ([0-9]+)/i","select top ($2+$3) $1",$sql);
			#pr($sql,1);
		}
		else if (strpos($db,"oci8") !== false || strpos($db,"db2") !== false)
		{
			$sql = preg_match("/(.*) LIMIT ([0-9]+) OFFSET ([0-9]+)/i",$sql,$matches);
		
			$query = $matches[1];
			$limit = $matches[2];
			$offest = $matches[3];

			$offset_min = $offest;
			$offset_max = $offest + $limit;
			
			$sql = "
				SELECT * FROM (
					SELECT rownum rnum,a.*
					FROM ($query) a
				)
				WHERE rnum BETWEEN $offset_min AND $offset_max
			";			
		}
		### P-END ###

		return $sql;
	}

	// replace any param in data pattern e.g. http://domain.com?id={id} given that, there is a $col["name"] = "id" exist
	function replace_row_data($row,$str)
	{
		foreach($this->options["colModel"] as $link_c)
		{
			$link_row_data = $row[$link_c["name"]];
			$str = str_replace("{".$link_c["name"]."}", $link_row_data, $str);
		}
		return $str;
	}
}

# In PHP 5.2 or higher we don't need to bring this in
if (!function_exists('json_encode')) 
{
	require_once 'JSON.php';
	function json_encode($arg)
	{
		global $services_json;
		if (!isset($services_json)) {
			$services_json = new Services_JSON();
		}
		return $services_json->encode($arg);
	}

	function json_decode($arg)
	{
		global $services_json;
		if (!isset($services_json)) {
			$services_json = new Services_JSON();
		}
		return $services_json->decode($arg);
	}
}

/**
 * Common function to display errors
 */
if (!function_exists('phpgrid_error'))
{
	function phpgrid_error($msg)	
	{
		header('HTTP/1.1 500 Internal Server Error');
		die($msg);	
	}
}

/**
 * Internal debug function
 */
if (!function_exists('phpgrid_pr'))
{
	function phpgrid_pr($arr, $exit=0)
	{
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		
		if ($exit)
			die;
	}
}

/**
 * Function to encode JS function reference from PHP array
 * http://www.php.net/manual/en/function.json-encode.php#105749
 */
function json_encode_jsfunc($input=array(), $funcs=array(), $level=0)
{
	foreach($input as $key=>$value)
	{
		if (is_array($value))
		{
			$ret = json_encode_jsfunc($value, $funcs, 1);
			$input[$key]=$ret[0];
			$funcs=$ret[1];
		}
		else
		{
			if (substr($value,0,8)=='function')
			{
				$func_key="#".uniqid()."#";
				$funcs[$func_key]=$value;
				$input[$key]=$func_key;
			}
			// for json data, incase of local array
			else if (substr($value,0,2)=='[{')
			{
				$func_key="#".uniqid()."#";
				$funcs[$func_key]=$value;
				$input[$key]=$func_key;
			}
		}
	}
  	if ($level==1)
	{
		return array($input, $funcs);
	}
  	else
	{
		$input_json = json_encode($input);
	  	foreach($funcs as $key=>$value)
		{
			$input_json = str_replace('"'.$key.'"', $value, $input_json);
		}
	  	return $input_json;
	}
}