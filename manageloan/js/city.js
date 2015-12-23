function  setCity () {
 //alert(1222);
    var provinceList =[{"id":10,"name":"安徽省"},{"id":11,"name":"北京"},{"id":12,"name":"福建省"},{"id":13,"name":"甘肃省"},{"id":14,"name":"广东省"},{"id":15,"name":"广西省"},{"id":16,"name":"贵州省"},{"id":17,"name":"海南省"},{"id":18,"name":"河北省"},{"id":19,"name":"河南省"},{"id":20,"name":"黑龙江省"},{"id":21,"name":"湖北省"},{"id":22,"name":"湖南省"},{"id":23,"name":"吉林省"},{"id":24,"name":"江苏省"},{"id":25,"name":"江西省"},{"id":26,"name":"辽宁省"},{"id":27,"name":"内蒙古自治区"},{"id":28,"name":"宁夏回族自治区"},{"id":29,"name":"青海省"},{"id":30,"name":"山东省"},{"id":31,"name":"山西省"},{"id":32,"name":"陕西省"},{"id":33,"name":"上海"},{"id":34,"name":"四川省"},{"id":35,"name":"天津"},{"id":36,"name":"西藏自治区"},{"id":37,"name":"新疆维吾尔自治区"},{"id":38,"name":"云南省"},{"id":39,"name":"浙江省"},{"id":40,"name":"重庆"}];
    var cityList=		{"city_30":[{"id":372,"name":"菏泽市"},{"id":496,"name":"滨州市"},{"id":497,"name":"德州市"},{"id":498,"name":"东营市"},{"id":500,"name":"济南市"},{"id":501,"name":"济宁市"},{"id":502,"name":"莱芜市"},{"id":503,"name":"聊城市"},{"id":505,"name":"临沂市"},{"id":506,"name":"青岛市"},{"id":509,"name":"日照市"},{"id":510,"name":"泰安市"},{"id":512,"name":"威海市"},{"id":513,"name":"潍坊市"},{"id":516,"name":"烟台市"},{"id":517,"name":"枣庄市"},{"id":519,"name":"淄博市"}],"city_19":[{"id":163,"name":"安阳市"},{"id":164,"name":"鹤壁市"},{"id":166,"name":"焦作市"},{"id":167,"name":"开封市"},{"id":169,"name":"洛阳市"},{"id":170,"name":"南阳市"},{"id":171,"name":"平顶山市"},{"id":172,"name":"濮阳市"},{"id":173,"name":"三门峡市"},{"id":174,"name":"商丘市"},{"id":175,"name":"新乡市"},{"id":176,"name":"信阳市"},{"id":177,"name":"许昌市"},{"id":179,"name":"郑州市"},{"id":180,"name":"周口市"},{"id":181,"name":"驻马店市"},{"id":387,"name":"漯河市"},{"id":388,"name":"济源市"}],"city_32":[{"id":368,"name":"商洛市"},{"id":534,"name":"安康市"},{"id":535,"name":"宝鸡市"},{"id":536,"name":"汉中市"},{"id":539,"name":"铜川市"},{"id":540,"name":"渭南市"},{"id":541,"name":"西安市"},{"id":542,"name":"咸阳市"},{"id":543,"name":"延安市"},{"id":544,"name":"榆林市"}],"city_31":[{"id":369,"name":"吕梁市"},{"id":370,"name":"晋中市"},{"id":371,"name":"朔州市"},{"id":521,"name":"长治市"},{"id":522,"name":"大同市"},{"id":524,"name":"晋城市"},{"id":526,"name":"临汾市"},{"id":529,"name":"太原市"},{"id":530,"name":"忻州市"},{"id":531,"name":"阳泉市"},{"id":533,"name":"运城市"}],"city_15":[{"id":100,"name":"百色市"},{"id":101,"name":"北海市"},{"id":102,"name":"崇左市"},{"id":103,"name":"防城港市"},{"id":104,"name":"贵港市"},{"id":105,"name":"桂林市"},{"id":107,"name":"河池市"},{"id":108,"name":"贺州市"},{"id":109,"name":"来宾市"},{"id":110,"name":"柳州市"},{"id":111,"name":"南宁市"},{"id":113,"name":"钦州市"},{"id":114,"name":"梧州市"},{"id":115,"name":"玉林市"}],"city_34":[{"id":565,"name":"阿坝藏族羌族自治州"},{"id":567,"name":"成都市"},{"id":569,"name":"德阳市"},{"id":571,"name":"甘孜藏族自治州"},{"id":573,"name":"广元市"},{"id":575,"name":"乐山市"},{"id":576,"name":"凉山彝族自治州"},{"id":577,"name":"泸州市"},{"id":580,"name":"绵阳市"},{"id":581,"name":"内江市"},{"id":582,"name":"南充市"},{"id":583,"name":"攀枝花市"},{"id":584,"name":"遂宁市"},{"id":586,"name":"雅安市"},{"id":587,"name":"宜宾市"},{"id":589,"name":"自贡市"},{"id":363,"name":"资阳市"},{"id":364,"name":"广安市"},{"id":365,"name":"达州市"},{"id":366,"name":"巴中市"},{"id":367,"name":"眉山市"}],"city_33":[{"id":549,"name":"奉贤区"},{"id":550,"name":"虹口区"},{"id":551,"name":"黄浦区"},{"id":552,"name":"嘉定区"},{"id":553,"name":"金山区"},{"id":554,"name":"静安区"},{"id":555,"name":"卢湾区"},{"id":556,"name":"闵行区"},{"id":557,"name":"南汇区"},{"id":558,"name":"浦东新区"},{"id":559,"name":"普陀区"},{"id":560,"name":"青浦区"},{"id":561,"name":"松江区"},{"id":562,"name":"徐汇区"},{"id":563,"name":"杨浦区"},{"id":564,"name":"闸北区"},{"id":545,"name":"宝山区"},{"id":546,"name":"长宁区"},{"id":547,"name":"崇明县"}],"city_16":[{"id":116,"name":"安顺市"},{"id":117,"name":"毕节地区"},{"id":120,"name":"贵阳市"},{"id":122,"name":"六盘水市"},{"id":123,"name":"铜仁地区"},{"id":125,"name":"遵义市"},{"id":398,"name":"黔东南苗族侗族自治州"},{"id":399,"name":"黔南布依族苗族自治州"},{"id":400,"name":"黔西南布依族苗族自治州"}],"city_36":[{"id":608,"name":"阿里市"},{"id":609,"name":"昌都市"},{"id":610,"name":"拉萨市"},{"id":611,"name":"林芝市"},{"id":612,"name":"那曲市"},{"id":613,"name":"日喀则市"},{"id":614,"name":"山南市"}],"city_17":[{"id":126,"name":"白沙黎族自治县"},{"id":127,"name":"保亭黎族苗族自治县"},{"id":128,"name":"昌江黎族自治县"},{"id":130,"name":"儋州市"},{"id":133,"name":"海口市"},{"id":134,"name":"乐东黎族自治县"},{"id":135,"name":"临高县"},{"id":136,"name":"陵水黎族自治县"},{"id":138,"name":"琼中黎族苗族自治县"},{"id":139,"name":"三亚市"},{"id":389,"name":"五指山市"},{"id":390,"name":"文昌市"},{"id":392,"name":"屯昌县市"},{"id":393,"name":"东方市"},{"id":394,"name":"万宁市"},{"id":395,"name":"琼海市"},{"id":396,"name":"澄迈县"},{"id":397,"name":"定安县"}],"city_35":[{"id":590,"name":"宝坻区"},{"id":591,"name":"北辰区"},{"id":592,"name":"东丽区"},{"id":593,"name":"汉沽区"},{"id":594,"name":"和平区"},{"id":595,"name":"河北区"},{"id":596,"name":"河东区"},{"id":597,"name":"河西区"},{"id":598,"name":"红桥区"},{"id":599,"name":"津南区"},{"id":600,"name":"静海县"},{"id":601,"name":"南开区"},{"id":602,"name":"宁河县"},{"id":603,"name":"西青区"},{"id":604,"name":"大港区"},{"id":605,"name":"塘沽区"},{"id":606,"name":"蓟县"},{"id":607,"name":"武清县"}],"city_18":[{"id":145,"name":"保定市"},{"id":147,"name":"沧州市"},{"id":148,"name":"承德市"},{"id":150,"name":"邯郸市"},{"id":151,"name":"衡水市"},{"id":152,"name":"廊坊市"},{"id":154,"name":"秦皇岛市"},{"id":157,"name":"石家庄市"},{"id":158,"name":"唐山市"},{"id":160,"name":"邢台市"},{"id":161,"name":"张家口市"}],"city_11":[{"id":29,"name":"昌平区"},{"id":30,"name":"朝阳区"},{"id":31,"name":"崇文区"},{"id":32,"name":"大兴区"},{"id":33,"name":"东城区"},{"id":34,"name":"房山区"},{"id":35,"name":"丰台区"},{"id":36,"name":"海淀区"},{"id":37,"name":"怀柔区"},{"id":38,"name":"门头沟区"},{"id":39,"name":"密云县"},{"id":40,"name":"平谷区"},{"id":41,"name":"石景山区"},{"id":42,"name":"顺义区"},{"id":43,"name":"通州区"},{"id":44,"name":"西城区"},{"id":45,"name":"宣武区"},{"id":46,"name":"延庆县"}],"city_38":[{"id":639,"name":"保山市"},{"id":641,"name":"楚雄彝族自治州"},{"id":642,"name":"大理白族自治州"},{"id":644,"name":"德宏傣族景颇族自治州"},{"id":645,"name":"迪庆藏族自治州"},{"id":648,"name":"红河哈尼族彝族自治州"},{"id":651,"name":"昆明市"},{"id":652,"name":"丽江市"},{"id":653,"name":"临沧市"},{"id":656,"name":"怒江傈傈族自治州"},{"id":657,"name":"曲靖市"},{"id":658,"name":"普洱市"},{"id":660,"name":"文山壮族苗族自治州"},{"id":661,"name":"西双版纳傣族自治州"},{"id":662,"name":"玉溪市"},{"id":663,"name":"昭通市"}],"city_12":[{"id":48,"name":"福州市"},{"id":49,"name":"龙岩市"},{"id":50,"name":"南平市"},{"id":51,"name":"宁德市"},{"id":52,"name":"莆田市"},{"id":53,"name":"泉州市"},{"id":54,"name":"三明市"},{"id":57,"name":"厦门市"},{"id":59,"name":"漳州市"}],"city_37":[{"id":615,"name":"阿克苏地区"},{"id":619,"name":"巴音郭楞蒙古自治州"},{"id":620,"name":"博尔塔拉蒙古自治州"},{"id":622,"name":"昌吉回族自治州"},{"id":623,"name":"昌吉市"},{"id":624,"name":"哈密地区"},{"id":625,"name":"和田地区"},{"id":626,"name":"喀什地区"},{"id":628,"name":"克拉玛依市"},{"id":629,"name":"克孜勒苏柯尔克孜自治州"},{"id":632,"name":"石河子市"},{"id":634,"name":"吐鲁番地区"},{"id":635,"name":"乌鲁木齐市"},{"id":637,"name":"伊犁哈萨克自治州"},{"id":670,"name":"塔城地区"},{"id":671,"name":"阿勒泰地区"},{"id":360,"name":"图木舒克市"},{"id":361,"name":"阿拉尔市"},{"id":362,"name":"五家渠市"}],"city_13":[{"id":60,"name":"白银市"},{"id":61,"name":"定西市"},{"id":63,"name":"嘉峪关市"},{"id":64,"name":"金昌市"},{"id":65,"name":"酒泉市"},{"id":66,"name":"兰州市"},{"id":68,"name":"陇南市"},{"id":69,"name":"平凉市"},{"id":70,"name":"庆阳市"},{"id":71,"name":"天水市"},{"id":72,"name":"武威市"},{"id":75,"name":"张掖市"},{"id":404,"name":"甘南藏族自治州"},{"id":405,"name":"临夏回族自治州"}],"city_14":[{"id":76,"name":"潮州市"},{"id":78,"name":"东莞市"},{"id":79,"name":"佛山市"},{"id":80,"name":"广州市"},{"id":81,"name":"河源市"},{"id":82,"name":"惠州市"},{"id":83,"name":"江门市"},{"id":85,"name":"茂名市"},{"id":86,"name":"梅州市"},{"id":87,"name":"清远市"},{"id":88,"name":"汕头市"},{"id":89,"name":"汕尾市"},{"id":90,"name":"韶关市"},{"id":91,"name":"深圳市"},{"id":93,"name":"阳江市"},{"id":95,"name":"湛江市"},{"id":96,"name":"肇庆市"},{"id":97,"name":"中山市"},{"id":401,"name":"揭阳市"},{"id":402,"name":"珠海市"},{"id":403,"name":"云浮市"}],"city_39":[{"id":668,"name":"杭州市"},{"id":669,"name":"湖州市"},{"id":295,"name":"嘉兴市"},{"id":298,"name":"金华市"},{"id":300,"name":"丽水市"},{"id":302,"name":"宁波市"},{"id":303,"name":"衢州市"},{"id":306,"name":"绍兴市"},{"id":311,"name":"温州市"},{"id":316,"name":"舟山市"},{"id":359,"name":"台州市"}],"city_10":[{"id":10,"name":"安庆市"},{"id":11,"name":"蚌埠市"},{"id":12,"name":"亳州市"},{"id":13,"name":"巢湖市"},{"id":14,"name":"滁州市"},{"id":15,"name":"阜阳市"},{"id":16,"name":"合肥市"},{"id":17,"name":"淮北市"},{"id":18,"name":"淮南市"},{"id":19,"name":"黄山市"},{"id":20,"name":"六安市"},{"id":21,"name":"马鞍山市"},{"id":22,"name":"宿州市"},{"id":24,"name":"铜陵市"},{"id":25,"name":"芜湖市"},{"id":27,"name":"宣城市"},{"id":406,"name":"池州市"}],"city_21":[{"id":203,"name":"鄂州市"},{"id":205,"name":"恩施土家族苗族自治州"},{"id":207,"name":"黄冈市"},{"id":208,"name":"黄石市"},{"id":210,"name":"荆门市"},{"id":219,"name":"十堰市"},{"id":221,"name":"随州市"},{"id":222,"name":"天门市"},{"id":223,"name":"武汉市"},{"id":225,"name":"仙桃市"},{"id":227,"name":"咸宁市"},{"id":228,"name":"襄樊市"},{"id":229,"name":"孝感市"},{"id":230,"name":"宜昌市"},{"id":383,"name":"神农架林区市"},{"id":384,"name":"荆州市"},{"id":385,"name":"潜江市"}],"city_20":[{"id":184,"name":"大庆市"},{"id":186,"name":"哈尔滨市"},{"id":187,"name":"鹤岗市"},{"id":188,"name":"黑河市"},{"id":189,"name":"鸡西市"},{"id":190,"name":"佳木斯市"},{"id":191,"name":"牡丹江市"},{"id":192,"name":"七台河市"},{"id":193,"name":"齐齐哈尔市"},{"id":194,"name":"双鸭山市"},{"id":196,"name":"绥化市"},{"id":199,"name":"伊春市"},{"id":386,"name":"大兴安岭地区"}],"city_25":[{"id":416,"name":"抚州市"},{"id":417,"name":"赣州市"},{"id":418,"name":"吉安市"},{"id":420,"name":"景德镇市"},{"id":421,"name":"九江市"},{"id":424,"name":"南昌市"},{"id":425,"name":"萍乡市"},{"id":426,"name":"上饶市"},{"id":427,"name":"新余市"},{"id":428,"name":"宜春市"},{"id":429,"name":"鹰潭市"}],"city_24":[{"id":278,"name":"常州市"},{"id":281,"name":"淮安市"},{"id":286,"name":"连云港市"},{"id":287,"name":"南京市"},{"id":288,"name":"南通市"},{"id":290,"name":"苏州市"},{"id":291,"name":"宿迁市"},{"id":292,"name":"泰州市"},{"id":293,"name":"无锡市"},{"id":408,"name":"徐州市"},{"id":409,"name":"盐城市"},{"id":410,"name":"扬州市"},{"id":414,"name":"镇江市"}],"city_23":[{"id":256,"name":"白城市"},{"id":257,"name":"白山市"},{"id":258,"name":"长春市"},{"id":264,"name":"吉林市"},{"id":267,"name":"辽源市"},{"id":270,"name":"四平市"},{"id":273,"name":"通化市"},{"id":381,"name":"延边朝鲜族自治州"},{"id":382,"name":"松原市"}],"city_22":[{"id":233,"name":"长沙市"},{"id":234,"name":"常德市"},{"id":235,"name":"郴州市"},{"id":236,"name":"衡阳市"},{"id":238,"name":"怀化市"},{"id":245,"name":"娄底市"},{"id":247,"name":"邵阳市"},{"id":248,"name":"湘潭市"},{"id":249,"name":"湘西土家族苗族自治州"},{"id":251,"name":"益阳市"},{"id":252,"name":"永州市"},{"id":253,"name":"岳阳市"},{"id":254,"name":"张家界市"},{"id":255,"name":"株洲市"}],"city_40":[{"id":318,"name":"巴南区"},{"id":319,"name":"北碚区"},{"id":320,"name":"璧山县"},{"id":321,"name":"长寿区"},{"id":322,"name":"城口县"},{"id":323,"name":"大足县"},{"id":324,"name":"垫江县"},{"id":325,"name":"大渡口区"},{"id":326,"name":"丰都县"},{"id":327,"name":"奉节县"},{"id":328,"name":"涪陵区"},{"id":329,"name":"合川区"},{"id":330,"name":"江北区"},{"id":331,"name":"江津区"},{"id":332,"name":"九龙坡区"},{"id":333,"name":"开县"},{"id":334,"name":"梁平县"},{"id":335,"name":"南岸区"},{"id":336,"name":"南川区"},{"id":337,"name":"彭水苗族土家族自治县"},{"id":338,"name":"綦江县"},{"id":339,"name":"黔江区"},{"id":340,"name":"荣昌县"},{"id":341,"name":"沙坪坝区"},{"id":342,"name":"石柱土家族自治县"},{"id":343,"name":"双桥区"},{"id":344,"name":"铜梁县"},{"id":345,"name":"潼南县"},{"id":346,"name":"万盛区"},{"id":348,"name":"万州区"},{"id":349,"name":"巫山县"},{"id":350,"name":"巫溪县"},{"id":351,"name":"武隆县"},{"id":352,"name":"秀山土家族苗族自治县"},{"id":353,"name":"永川区"},{"id":354,"name":"酉阳土家族苗族自治县"},{"id":355,"name":"渝北区"},{"id":356,"name":"云阳县"},{"id":357,"name":"忠县"},{"id":358,"name":"渝中区"}],"city_29":[{"id":483,"name":"果洛藏族自治州"},{"id":484,"name":"海北藏族自治州"},{"id":485,"name":"海东市"},{"id":486,"name":"海南藏族自治州"},{"id":487,"name":"海西蒙古族藏族自治州"},{"id":489,"name":"黄南藏族自治州"},{"id":493,"name":"西宁市"},{"id":494,"name":"玉树藏族自治州"}],"city_28":[{"id":474,"name":"固原市"},{"id":476,"name":"石嘴山市"},{"id":477,"name":"吴忠市"},{"id":478,"name":"银川市"},{"id":479,"name":"中卫市"}],"city_27":[{"id":373,"name":"乌兰察布市"},{"id":374,"name":"锡林郭勒盟"},{"id":375,"name":"兴安盟"},{"id":376,"name":"呼伦贝尔市"},{"id":377,"name":"鄂尔多斯市"},{"id":378,"name":"阿拉善盟市"},{"id":379,"name":"巴彦淖尔盟市"},{"id":453,"name":"包头市"},{"id":454,"name":"赤峰市"},{"id":459,"name":"呼和浩特市"},{"id":465,"name":"通辽市"},{"id":466,"name":"乌海市"}],"city_26":[{"id":380,"name":"葫芦岛市"},{"id":430,"name":"鞍山市"},{"id":432,"name":"本溪市"},{"id":434,"name":"朝阳市"},{"id":435,"name":"大连市"},{"id":436,"name":"丹东市"},{"id":437,"name":"抚顺市"},{"id":438,"name":"阜新市"},{"id":442,"name":"锦州市"},{"id":443,"name":"辽阳市"},{"id":444,"name":"盘锦市"},{"id":445,"name":"沈阳市"},{"id":447,"name":"铁岭市"},{"id":450,"name":"营口市"}]}
 
    //填充省份选择列表
    jQuery("#provinceSelectContainer").empty();  
    var a=$("#province").val();	
    jQuery.each(provinceList, function () {
    	//默认的省份   	
         if(a==this.id)
        	 { 
        	  jQuery("#provinceName").val(this.name);
        	 } 	
        var html = "<li class='provinceSelectItem' id="+this.id+"  data-value='" + this.id + "' data-show='" + this.name + "'>" + this.name + "</li>";
        jQuery("#provinceSelectContainer").append(jQuery(html));
    });
     if($("#province").val()=='0')
	   {
	   //没有匹配到城市
	   jQuery("#provinceName").val("请选择");
	   
	   }
    //默认城市
     
    for(var key in cityList)
    {
     
	  if("city_"+a==key)
		  {	    
        	    jQuery.each(cityList[key], function () {
        	    	if($("#city" ).val()==this.id)
        	    		{
        	    		 
        	     	  jQuery("#cityName").val(this.name);
                         
        	    		}       	    
      	    	 
  	    	      var html = "<li class='citySelectItem' id="+this.id+"  data-value='" + this.id + "' data-show='" + this.name + "'>" + this.name + "</li>";
        	        jQuery("#citySelectContainer").append(jQuery(html));
      	    
    	    });
		  }
	  
    }
    
      if($("#city").val()=='0')
	   {
	   //没有匹配到城市
	   jQuery("#cityName").val("请选择");
	   
	   }
    //省份选择项添加事件
    jQuery(".citySelectItem").click(function () {
 
        //给输入框复制
     
      jQuery("#cityName").val(jQuery(this).attr('data-show'));
        //给输入复制
    //    var provId=jQuery(this).attr('data-value');
      //  inputs.provinceValue = jQuery(this).attr('data-value');
        jQuery("#city").val(jQuery(this).attr('data-value'));
 
        //隐藏下拉
        jQuery("#citySelectContainer").hide();
        
        
    });
    
    
    //省份选择项添加事件
    jQuery(".provinceSelectItem").click(function () {
 
        //给输入框复制
        jQuery("#provinceName").val(jQuery(this).attr('data-show'));
        //给输入复制
        var provId=jQuery(this).attr('data-value');
      //  inputs.provinceValue = jQuery(this).attr('data-value');
        jQuery("#province").val(jQuery(this).attr('data-value'));
    
        //隐藏下拉
        jQuery("#provinceSelectContainer").hide();
        
        
        //省份城市级联
       
        jQuery("#citySelectContainer").empty();
      //  inputs.provinceValue = "请选择";
    
          for(var key in cityList)
            {
         
        	  if("city_"+provId==key)
        		  {
        		   
                	   jQuery.each(cityList[key], function () {
                		 
                 	  jQuery("#cityName").val(this.name);
               	      
                 	   jQuery("#city").val(this.id);
	        	        var html = "<li class='citySelectItem' id="+this.id+"  data-value='" + this.id + "' data-show='" + this.name + "'>" + this.name + "</li>";
	        	        jQuery("#citySelectContainer").append(jQuery(html));
	        	        
	        	     
	        	    });
        		  }
        	  
        	  
        	   //省份选择项添加事件
        	    jQuery(".citySelectItem").click(function () {

        	        //给输入框复制
        	     
        	        jQuery("#cityName").val(jQuery(this).attr('data-show'));
        	        //给输入复制
           	        jQuery("#city").val(jQuery(this).attr('data-value'));
           	     
        	        //隐藏下拉
        	        jQuery("#citySelectContainer").hide();

        	    });

        
            }

     
 
        
        

    

    
 
      
    


 

 
 
 

  
}); }