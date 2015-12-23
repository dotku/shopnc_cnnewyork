/**
 * id:贷款产品对应ID
 */

function applyLoan(url) {
	$.layer({
		type : 2,
		shadeClose : false,
		title : false,
		closeBtn : [ 0, true ],
		fix : true,
		area : [ '640px', '540px' ],
		iframe : {
			src : url,
			scrolling : 'no'
		}
	});
}

function doLoginBeforeApply(url) {
	$.layer({
		type : 2,
		shadeClose : false,
		title : false,
		closeBtn : [ 0, true ],
		fix : true,
		area : [ '745px', '313px' ],
		// zIndex: 100,
		iframe : {
			src : url,
			scrolling : 'no'
		}
	});
}