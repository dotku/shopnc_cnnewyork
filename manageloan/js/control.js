/**
 * Copy Right Information	: hc360.com WebF2E
 * Project					: control
 * jQuery version used		: 1.6
 * Comments					: control
 * Version					: 1.00
 * Modification history		: 2013.5.29
 * F2E Common Control
 * 1. 2011.9.15	慧聪网技术中心 WEB前端 zyy
 */
 
/*添加百度监测代码，以统计去除爬虫的全站流量*/
function getpagetype(){
    var ifrtrue="";
    try{
        window.top.location.href;
    }
    catch(exp){
        var ifrtrue=2;
    }
    if(ifrtrue!=2){
        window.location.href==window.top.location.href?ifrtrue=0:ifrtrue=1;
        if(window.top.location.href==undefined){
            var ifrtrue=2;
        }
    }
    return ifrtrue;
}
if(getpagetype()===0){
    var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://"); 
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Fe1e386be074a459371b2832363c0d7e7' type='text/javascript'%3E%3C/script%3E")); 
}

/**
 * 载入用户行为分析脚本
 */
document.write("<script src='../manage_loan/js/logrecordservice.js'><\/script>");

/*前端性能框架JS*/
HC.HUB.addEvent(window,function(){
    HC.HUB.addScript('../manage_loan/js/performance.js');
},"load")

