<?php

class ClueController extends Controller
{

	/**
     * 权限规则
     */
    public function accessRules() {
        return CMap::mergeArray(
            array(
                array(
                    'allow',
                    'actions'=>array('index',  'wapIndex', 'showClues'),
                    'users'=>array('*'),
                ),
                array(
                    'allow',
                    'actions'=>array('admin'),
                    'expression'=>'$user->isAdmin()',
                ),
            ),
            parent::accessRules()
        );
    }   

	public function actionShowClues()
	{
		$curTime = time();
		$connection = Yii::app()->db;  
		$sql = "SELECT * FROM `hfs_det_season` where UNIX_TIMESTAMP(starttime) <".$curTime." and UNIX_TIMESTAMP(endtime) >".$curTime.";";  
		$command = $connection->createCommand($sql);  
		$dbresult = $command->queryAll();  
		$curSeason = intval($dbresult[0]['season']);
		$curAnswer = $dbresult[0]['answer'];		

		$sql = "SELECT * FROM `hfs_det_clue` where season_id = ".$curSeason.";";
                $command = $connection->createCommand($sql);
                $dbresult = $command->queryAll();
		
		$arrClues = array();
		if(is_array($dbresult) && !empty($dbresult)){
			foreach($dbresult as $clue){
				$arrTmp = array();
				$arrTmp['opentime'] = intval(strtotime($clue['starttime'])) * 1000;
				$arrTmp['type'] = intval($clue['clue_type']) == 1 ? 'image' : 'mp3';
				$arrTmp['source'] = $cule['clue_addr'];
				$arrClues[] = $arrTmp;
			}
		}
		
		$this->render('showClues',array('clues'=>$arrClues,'ans'=>$curAnswer));
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}
