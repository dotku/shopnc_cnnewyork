<?php
class loanControl extends BaseLoanControl{
	public function insertOp(){
		$institution=$_GET['institution'];
		$logo=$_GET['logo'];
		$userType=$_GET['userType'];
		$repaymentType=$_GET['repaymentType'];
		$loanMoneyMinLimit=$_GET['loanMoneyMinLimit'];
		$loanMoneyMaxLimit=$_GET['loanMoneyMaxLimit'];
		$loanTimeMinLimit=$_GET['loanTimeMinLimit'];
		$loanTimeMaxLimit=$_GET['loanTimeMaxLimit'];
		$carType=intval($_GET['carType']);
		$houseType=intval($_GET['houseType']);
		$creditRecord=intval($_GET['creditRecord']);
		$examineDay=intval($_GET['examineDay']);
		$loanInterest=intval($_GET['loanInterest']);
	}
	
	public function conditionQueryOp(){
		$amount=intval($_GET['amount']);
		$dateLimit=intval($_GET['dateLimit']);
		$memberType=intval($_GET['memberType']);
		$carType=intval($_GET['carType']);
		$houseType=intval($_GET['houseType']);
		$creditrecordType=intval($_GET['creditrecordType']);
		$model=Model("loan");
		$info=$model->where(
			  array("amount"<=$amount)
			  and array("dateLimit"<=$dateLimit)
			  and array("memberType"===$memberType)
			  and array("carType"===$carType)
		      and array("hourseType"===$houseType)
			  and array("creditrecordType"===$creditrecordType)
		)->select();
		return $info;
	}
}