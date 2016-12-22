<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of ManagerController
 *
 * @author wc
 */
class ManagerController extends AdminController {

    //put your code here
    public function index() {
        $this->meta_title = 'Manager Page';
        $map = array();
        $is_employee = I('is_employee', '');
        if ($is_employee != '') {
            if ($is_employee == 1) {
                $eSqlBuild = M('Employee')->field('Talent_ID')->buildSql();
            } else {
                $eSqlBuild = M('Unemployment')->field('Talent_ID')->buildSql();
            }
            $map['_string'] = "a.Talent_ID in {$eSqlBuild}";
        }
        $degree_list = I('degree_list', '');
        if ($degree_list != '') {
            $map['b.Degree'] = $degree_list;
        }
        $position_list = I('position_list', '');
        if ($position_list != '') {
            $map['e.Position_ID'] = $position_list;
        }
        $xp_list = I('xp_list', '');
        if ($xp_list != '') {
            switch ($xp_list) {
                case 1:
                    $map['a.Xp'] = array('between', '0,200');
                    break;
                case 2:
                    $map['a.Xp'] = array('between', '200,400');
                    break;
                case 3:
                    $map['a.Xp'] = array('between', '400,600');
                    break;
                case 4:
                    $map['a.Xp'] = array('between', '600,800');
                    break;
                case 5:
                    $map['a.Xp'] = array('between', '800,1001');
                    break;

                default:
                    break;
            }
        }
        $level_list = I('level_list', '');
        if ($level_list != '') {
            switch ($level_list) {
                case 1:
                    $map['a.Level'] = array('between', '0,20');
                    break;
                case 2:
                    $map['a.Level'] = array('between', '20,40');
                    break;
                case 3:
                    $map['a.Level'] = array('between', '40,60');
                    break;
                case 4:
                    $map['a.Level'] = array('between', '60,80');
                    break;
                case 5:
                    $map['a.Level'] = array('between', '80,101');
                    break;

                default:
                    break;
            }
        }
        $model = M('Talent a')
                ->join('LEFT JOIN __TALENT_GRDFM_UNIVERSITY__ b on a.Talent_ID=b.Talent_ID')
                ->join("LEFT JOIN __UNIVERSITY__ c on b.University_ID=c.University_ID")
//                ->join("LEFT JOIN __TALENT_HAVE_SKILL__ f on a.Talent_ID=f.Talent_ID")
//                ->join("LEFT JOIN __SKILL__ g on f.Skill_ID=f.Skill_ID")
                ->join("LEFT JOIN __EMPLOYEE__ d on a.Talent_ID=d.Talent_ID")
                ->join("LEFT JOIN __POSITION__ e on d.Position_ID=e.Position_ID");
//        $map['f.Skill_Score']=82;
//        $map['f.Skill_ID']=5;
        $mapSql = array();

        $sid_list = I('sid_list', '');
        if ($sid_list != '') {
            $mapSql['Skill_ID'] = $sid_list;
        }
        $sscore_list = I('sscore_list', '');
        if ($sscore_list != '') {
            switch ($sscore_list) {
                case 1:
                    $mapSql['Skill_Score'] = array('between', '0,20');
                    break;
                case 2:
                    $mapSql['Skill_Score'] = array('between', '20,40');
                    break;
                case 3:
                    $mapSql['Skill_Score'] = array('between', '40,60');
                    break;
                case 4:
                    $mapSql['Skill_Score'] = array('between', '60,80');
                    break;
                case 5:
                    $mapSql['Skill_Score'] = array('between', '80,101');
                    break;

                default:
                    break;
            }
        }
        $list_buildSql1 = M('TalentHaveSkill')->field('Talent_ID')->where($mapSql)->buildSql();
        if ($mapSql) {
            $map['_string'] = "a.Talent_ID in {$list_buildSql1}";
        }
        $list = $this->lists($model, $map, 'a.Talent_ID', "*,a.Talent_ID talent_id");
        int_to_string($list, array(
            'status' => C('TALENTSTATUS'),
            'degree' => C('DEGREE'),
            'gender' => C('GENDER')
        ));
        $positionSelect = M('Position')->distinct(true)->select();
        $sidSelect = M('Skill')->distinct(true)->select();
        $this->assign('list', $list);
        $date_project = I('date_project', 0);
        switch ($date_project) {
            case 1:$projectOrder = 'a.End_Date desc';
                break;
            case 2:$projectOrder = 'a.End_Date';
                break;
            case 3:$projectOrder = 'rank desc';
                break;
            case 4:$projectOrder = 'rank';
                break;

            default:
                break;
        }
        $mapProject = array();
        $sid_project = I('sid_project', '');
        if ($sid_project != '') {
            $mapProject['c.Skill_ID'] = $sid_project;
        }
        $year_project = I('year_project', '');
        if ($year_project != '') {
            $mapProject['a.End_Date'] = $year_project;
        }
        $project = M('Project a')->join("LEFT JOIN __PROJECT_INCLUDE_SKILL__ b on a.Project_ID=b.Project_ID")
                ->join('LEFT JOIN __SKILL__ c on b.Skill_ID=c.Skill_ID')
                ->join("LEFT JOIN __TALENT__ d on a.Pro_Mgr_Talent_ID=d.Talent_ID")
                ->where($mapProject)
                ->order($projectOrder)
                ->field("*,a.Project_ID project_id")
                ->select();
        $projectSelectYear = M('Project')->field("distinct(End_Date)")->select();

        
        
        $date_training = I('date_project', 0);
        switch ($date_training) {
            case 1:$trainingOrder = 'a.End_Date desc';
                break;
            case 2:$trainingOrder = 'a.End_Date';
                break;
            case 3:$trainingOrder = 'rank desc';
                break;
            case 4:$trainingOrder = 'rank';
                break;

            default:
                break;
        }
        $mapTraining= array();
        $sid_training = I('sid_training', '');
        if ($sid_training != '') {
            $mapTraining['c.Skill_ID'] = $sid_training;
        }
        $year_training = I('year_training', '');
        if ($year_training != '') {
            $mapTraining['a.End_Date'] = $year_training;
        }
        $training = M('Training a')->join("LEFT JOIN __TRAINING_INCLUDE_SKILL__ b on a.Training_ID=b.Training_ID")
                ->join('LEFT JOIN __SKILL__ c on b.Skill_ID=c.Skill_ID')
                ->join('LEFT JOIN __EMPLOYEE_DO_TRAINING__ d on a.Training_ID=d.Training_ID')
                ->where($mapTraining)
                ->order($trainingOrder)
                ->field("*,count(d.Talent_ID) count,a.Training_ID training_id")
                ->group("c.Skill_ID,a.Training_ID")
                ->select();
        $trainingSelectYear = M('Training')->field("distinct(End_Date)")->select();
        $this->assign('positionSelect', $positionSelect);
        $this->assign('sidSelect', $sidSelect);
        $this->assign('project', $project);
        $this->assign('projectSelectYear', $projectSelectYear);
        $this->assign('trainingSelectYear', $trainingSelectYear);
        $this->assign('training', $training);
        $this->display();
    }
    public function addProject() {
        if(IS_POST){
            $Config = D('Project');
            $data = $Config->create();
            if($data){
                if($Config->add()){
                    $this->success('success',U('index'));
                } else {
                    $this->error('error');
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $this->meta_title = 'addProjet';
            $this->assign('info',null);
            $this->display('editProject');
        }
    }
    public function addTraining() {
        if(IS_POST){
            $Config = D('Training');
            $data = $Config->create();
            if($data){
                if($Config->add()){
                    $this->success('success',U('index'));
                } else {
                    $this->error('error');
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $this->meta_title = 'addTraining';
            $this->assign('info',null);
            $this->display('editTraining');
        }
    }
    public function addProjectSkill($Project_ID) {
        if(IS_POST){
            $Config = D('ProjectIncludeSkill');
            $data = $Config->create();
            if($data){
                if($Config->add()){
                    $this->success('success', U('index'));
                } else {
                    $this->error('error');
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Project')->field(true)->find($Project_ID);
            $skillSelect=M('Skill')->select();
            if(false === $info){
                $this->error('error');
            }
            $this->assign('info', $info);
            $this->assign('skillSelect', $skillSelect);
            $this->meta_title = 'addProjectSkill';
            $this->display();
        }
    }
    
    public function addTrainingSkill($Training_ID) {
        if(IS_POST){
            $Config = D('TrainingIncludeSkill');
            $data = $Config->create();
            if($data){
                if($Config->add()){
                    $this->success('success', U('index'));
                } else {
                    $this->error('error');
                }
            } else {
                $this->error($Config->getError());
            }
        } else {
            $info = array();
            /* 获取数据 */
            $info = M('Training')->field(true)->find($Training_ID);
            $skillSelect=M('Skill')->select();
            if(false === $info){
                $this->error('error');
            }
            $this->assign('info', $info);
            $this->assign('skillSelect', $skillSelect);
            $this->meta_title = 'addTrainingSkill';
            $this->display();
        }
    }
}
