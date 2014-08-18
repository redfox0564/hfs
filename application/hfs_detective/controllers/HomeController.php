<?php

class HomeController extends Controller
{
    /**
     * 加载默认使用的布局
     */
    public $layout = NULL;
    private $curSeason = 1;
    private $curAnswer = '';
    private $connection = '';
    /**
     * 权限规则
     */
    public function accessRules() {
        return CMap::mergeArray(
            array(
                array(
                    'allow',
                    'actions'=>array('index',  'wapIndex'),
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
    
//////////////////////////////// PC ////////////////////////////////
    /**
     * 入口
     * 
     */
    public function actionIndex()
    {
        //  初始化
        $userId     = Yii::app()->user->id;
        $this->pageTitle    = '海飞丝实力音乐侦探';
        
        //  授权验证
//        $login = new CustomLogin();
//        $login->login();
        if ( JYii::isMobileClient() ) {
            Yii::app()->getRequest()->redirect(Yii::app()->createUrl('home/wapIndex', array ('source' => 'local')));
        }
        
        //  Render
	$this->initSeason();
                $sql = "SELECT * FROM `hfs_det_clue` where season_id = ".$this->curSeason.";";
                $command = $this->connection->createCommand($sql);
                $dbresult = $command->queryAll();
                $arrClues = array();
                if(is_array($dbresult) && !empty($dbresult)){
                        foreach($dbresult as $clue){
                                $arrTmp = array();
                                $arrTmp['opentime'] = intval(strtotime($clue['starttime'])) * 1000;
                                $arrTmp['type'] = intval($clue['clue_type']) == 1 ? 'image' : 'mp3';
                                $arrTmp['source'] = $clue['clue_addr'];
                                $arrClues[] = $arrTmp;
                        }
                }
        $this->render('index', array('clues'=>$arrClues));
    }
    
//////////////////////////////// WAP ////////////////////////////////
    /**
     * WAP跳转页
     */
    public function actionWapIndex()
    {
        //  初始化
        $this->layout   = '//layouts/main-wap';
        $this->pageTitle= '海飞丝实力音乐侦探';
        
        //  授权验证
//        $login = new CustomLogin();
//        $login->login();
        
        //  Render
	$this->initSeason();

                $sql = "SELECT * FROM `hfs_det_clue` where season_id = ".$this->curSeason.";";
                $command = $this->connection->createCommand($sql);
                $dbresult = $command->queryAll();
                $arrClues = array();
                if(is_array($dbresult) && !empty($dbresult)){
                        foreach($dbresult as $clue){
                                $arrTmp = array();
                                $arrTmp['opentime'] = intval(strtotime($clue['starttime'])) * 1000;
                                $arrTmp['type'] = intval($clue['clue_type']) == 1 ? 'image' : 'mp3';
                                $arrTmp['source'] = $clue['clue_addr'];
                                $arrClues[] = $arrTmp;
                        }
                }
        $this->render('wap-index', array('clues'=>$arrClues));
    }

    public function actionWinner()
    {
	$this->pageTitle= '海飞丝实力音乐侦探';
	$this->initSeason();        
 
                $sql = "SELECT * FROM `hfs_det_pubwinner` where win_seasonid = ".(intval($this->curSeason)-1).";";
                $command = $this->connection->createCommand($sql);
                $dbresult = $command->queryAll();
                
                $arrWinners = array();
                if(is_array($dbresult) && !empty($dbresult)){
                        foreach($dbresult as $winUser){
                                $arrTmp = array();
                                $arrWinners[] = $winUser['phone'];
                        }       
                }               
        $this->render('winner', array('winners'=>$arrWinners));	
    }

    public function actionUpdateWinner(){
	$this->initSeason();
	
	$sql = "INSERT INTO `hfs_det_winner` (`name`,`phone`,`win_seasonid`,`win_time`) values (`".$_POST['name']."`,`".$_POST['phone']."`,`".$this->curSeason."`,`".time()."`);";
	$command = $this->connection->createCommand($sql);
        $dbresult = $command->query();
    }

    private function initSeason(){
	$curTime = time();
                $this->connection = Yii::app()->db;
                $sql = "SELECT * FROM `hfs_det_season` where UNIX_TIMESTAMP(starttime) <".$curTime." and UNIX_TIMESTAMP(endtime) >".$curTime.";";
                $command = $this->connection->createCommand($sql);
                $dbresult = $command->queryAll();
                $this->curSeason = intval($dbresult[0]['season']);
                $this->curAnswer = $dbresult[0]['answer'];
	return true;
    }
 
    public function actionAdmin()
    {
        echo 'is Admin Action';
    }
}
