<?php
class Controller extends CController {
    public $menu=array();
    public $breadcrumbs=array();
    public $layout='//layouts/column2';
    
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xF7F7F7
            ),
            'page' => array(
                'class' => 'CViewAction'
            )
        );
    }
    protected function registerAssets() {
        Yii::app()->clientScript->registerCoreScript('jquery');
        $this->registerJs('webroot.js.jstree','jquery.jstree.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/json2.js');
    }
    protected static function registerCssAndJs($folder,$jsfile,$cssfile) {
        $sourceFolder=YiiBase::getPathOfAlias($folder);
        $publishedFolder=Yii::app()->assetManager->publish($sourceFolder);
        Yii::app()->clientScript->registerScriptFile($publishedFolder.$jsfile,CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerCssFile($publishedFolder.$cssfile);
    }
    protected static function registerJs($folder,$jsfile) {
        $sourceFolder=YiiBase::getPathOfAlias($folder);
        $publishedFolder=Yii::app()->assetManager->publish($sourceFolder);
        Yii::app()->clientScript->registerScriptFile($publishedFolder.'/'.$jsfile);
        return $publishedFolder.'/'.$jsfile;
    }
    public function actionFetchTree($id='admin') {
        $categories=Menu::model()->findAll(array('order'=>'root,lft'));
        $level=0;
        foreach($categories as $n=>$category) {
            if($category->level==$level) 
                echo CHtml::closeTag('li')."\n";
            elseif($category->level>$level) 
                echo CHtml::openTag('ul',array('id'=>'navmenu-v'))."\n";
            else {
                echo CHtml::closeTag('li')."\n";
                for($i=$level-$category->level;$i;$i--) {
                    echo CHtml::closeTag('ul')."\n";
                    echo CHtml::closeTag('li')."\n";
                }
            }
            echo CHtml::openTag('li',array('id'=>'node_'.$category->id,'rel'=>$category->name));
            if($id=='index') 
                echo CHtml::openTag('a',array('href'=>$this->createUrl('/products',array('id'=>$category->id,'title'=>$category->name))));
            else 
                echo CHtml::openTag('a',array('href'=>'#'));
            echo CHtml::encode($category->name);
            echo CHtml::closeTag('a');
            $level=$category->level;
        }
        for($i=$level;$i;$i--) {
            echo CHtml::closeTag('li')."\n";
            echo CHtml::closeTag('ul')."\n";
        }
    }
    protected function _loadBreadcrumbs($model,$menu_id='') {
        $o=Menu::model()->findAll(array('select'=>'id,name','condition'=>'lft<'.$model->lft.' AND rgt>'.$model->rgt,'order'=>'lft'));
        if(!empty($o)) {
            foreach($o as $value) {
                $b[]=$value->attributes;
            }
            foreach($b as $value) {
                $this->breadcrumbs[$value['name']]=$this->createUrl('/products',array('id'=>$value['id'],'title'=>$value['name']));
            }
        }
        $p=array(
            'Products'=>$this->createUrl('products/random'),
        );
        $this->breadcrumbs=$p+$this->breadcrumbs;
        if(!empty($menu_id)) 
            $this->breadcrumbs[$model->name]=$this->createUrl('/products',array('id'=>$menu_id,'title'=>$model->name));
        else 
            array_push($this->breadcrumbs,$model->name);
    }
}
