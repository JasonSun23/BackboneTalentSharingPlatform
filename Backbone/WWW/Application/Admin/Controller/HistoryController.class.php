<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of HrController
 *
 * @author wc
 */
class HistoryController extends AdminController {

    //put your code here
    public function index() {
        $this->meta_title = 'My History';
        $myInfo = M('Talent')->find(UID);
        $gender = C('Gender');
        $talentStatus = C('TalentStatus');
        $myInfo['gender_text'] = $gender[$myInfo['gender']];
        $myInfo['status_text'] = $talentStatus[$myInfo['status']];
        $trainingMap = array();
        $trainingMap['Talent_ID'] = $myInfo['talent_id'];
        $trainingOrder1 = I('trainingOrder1', 0);
        switch ($trainingOrder1) {
            case 1:$trainingOrder1 = 'b.end_date desc';
                break;
            case 2:$trainingOrder1 = 'b.end_date';
                break;
            case 3:$trainingOrder1 = 'rank desc';
                break;
            case 4:$trainingOrder1 = 'rank';
                break;

            default:
                break;
        }
        $trainingFilter = '';
        $skill_id = I('skill_id', '');
        if ($skill_id != '') {
            $trainingFilter = " and c.Skill_ID={$skill_id}";
        }
        $training = M('EmployeeDoTraining a')->join('__TRAINING__ b on a.Training_ID=b.Training_ID')
                ->join('__TRAINING_INCLUDE_SKILL__ c on b.Training_ID=c.Training_ID')
                ->join("__SKILL__ d on c.Skill_ID=d.Skill_ID {$trainingFilter}")
                ->where($trainingMap)
                ->order($trainingOrder1)
                ->select();
        $trainingSelect1 = M('Skill')->select();
        $date_project = I('date_project', '');
        $order_project = '';
        if ($date_project != '') {
            switch ($date_project) {
                case 1:$order_project = 'b.end_date desc';
                    break;
                case 2:$order_project = 'b.end_date';
                    break;
                case 3:$order_project = 'rank desc';
                    break;
                case 4:$order_project = 'rank';
                    break;

                default:
                    break;
            }
        }
        $mapProject = array();
        $mapProject["a.Talent_ID"] = $myInfo['talent_id'];

        $skill_project = I('skill_project', '');
        if ($skill_project != '') {
            $mapProject["d.Skill_ID"] = $skill_project;
        }
        $project = M('EmployeeWorkonProject a')
                ->join("__TALENT__ e on a.Talent_ID=e.Talent_ID")
                ->join('__PROJECT__ b on a.Project_ID=b.Project_ID')
                ->join("__PROJECT_INCLUDE_SKILL__ c on b.Project_ID=c.Project_ID")
                ->join("__SKILL__ d on c.Skill_ID=d.Skill_ID")
                ->where($mapProject)
                ->order($order_project)
                ->select();
        $salary = M('Employee a')
                ->join("__POSITION__ b on a.Position_ID=b.Position_ID")
                ->join("__KPI__ c on a.Talent_ID=c.Talent_ID")
                ->join("__DEPARTMENT__ d on a.Department_ID=d.Deparment_ID and a.Company_ID=d.Company_ID")
                ->where(array('a.Talent_ID' => $myInfo['talent_id']))
                ->order('c.KPI_Period')
                ->field("*,b.Base_Salary+c.Score/100*d.Bonus salary")
                ->select();
        foreach ($salary as &$value) {
            $salary_b = M('kpi c')
                    ->join("__EMPLOYEE__ a on a.Talent_ID=c.Talent_ID  and c.KPI_Period='{$value['kpi_period']}'")
                    ->join("__POSITION__ b on a.Position_ID=b.Position_ID")
                    ->join("__DEPARTMENT__ d on a.Department_ID=d.Deparment_ID and a.Company_ID=d.Company_ID")
                    ->field("count(*) a,count(case when b.Base_Salary+c.Score/100*d.Bonus>{$value['salary']} then 1 else null end) b")
                    ->find();

            $myColleage = M('Employee')->field('Talent_ID')->where(array('Company_ID' => $value['company_id']))->buildSql();

            $buildKpiCount = M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string' => 'c.KPI_Period=a.KPI_Period'))->buildSql();
            $buildKpiCount1 = M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string' => 'c.KPI_Period=a.KPI_Period and c.Score>a.Score'))->buildSql();

            $buildKpiCount2 = M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string' => "c.Talent_ID in {$myColleage} and c.KPI_Period=a.KPI_Period"))->buildSql();
            $buildKpiCount3 = M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string' => "c.Talent_ID in {$myColleage} and c.KPI_Period=a.KPI_Period and c.Score>a.Score"))->buildSql();
            $kpiMap = array();
            $kpiMap['a.Talent_ID'] = $value['talent_id'];
            $kpiMap['a.KPI_Period'] = $value['kpi_period'];
            $kpiField = "*,{$buildKpiCount} c,{$buildKpiCount1} c1";
            $kpiField.=",{$buildKpiCount2} c2,{$buildKpiCount3} c3";
            $kpi = M('Kpi a')->field($kpiField)->where($kpiMap)->find();
            $value['rank_b_1'] = round((1 - $kpi['c1'] / $kpi['c']) * 100, 2);
            $value['rank_c_1'] = round((1 - $kpi['c3'] / $kpi['c2']) * 100, 2);
            $salary_c = M('kpi c')
                    ->join("__EMPLOYEE__ a on a.Talent_ID=c.Talent_ID  and c.KPI_Period='{$value['kpi_period']}'")
                    ->join("__POSITION__ b on a.Position_ID=b.Position_ID")
                    ->join("__DEPARTMENT__ d on a.Department_ID=d.Deparment_ID and a.Company_ID=d.Company_ID")
                    ->field("count(*) a,count(case when b.Base_Salary+c.Score/100*d.Bonus>{$value['salary']} then 1 else null end) b")
                    ->where(array('_string' => "c.Talent_ID in {$myColleage}"))
                    ->find();
            $value['rank_b'] = round((1 - $salary_b['b'] / $salary_b['a']) * 100, 2);
            $value['rank_c'] = round((1 - $salary_c['b'] / $salary_c['a']) * 100, 2);
        }
//        $kpi=M('Kpi a')->field($kpiField)->where($kpiMap)->order('a.KPI_Period desc')->find();
//        if($kpi){
//            $kpi['rank_b']=round((1-$kpi['c1']/$kpi['c'])*100,2);
//        }
//        
//        if($employee){
//            $kpi['rank_c']=round((1-$kpi['c3']/$kpi['c2'])*100,2);
//        }
        $skills = M('EmployeeWorkonProject a')
                ->join("__PROJECT__ d on a.Project_ID=d.Project_ID")
                ->join("__PROJECT_INCLUDE_SKILL__ b on a.Project_ID=b.Project_ID")
                ->join("__SKILL__ c on b.Skill_ID=c.Skill_ID")
                ->where(array('a.Talent_ID' => $myInfo['talent_id']))
                ->select();
        $result = array();
        foreach ($skills as $value) {
            if (key_exists($value['end_date'], $result)) {
                if (key_exists($value['skill_name'], $result[$value['end_date']])) {
                    $result[$value['end_date']][$value['skill_name']] = $result[$value['end_date']][$value['skill_name']] + $value["addition"];
                } else {
                    $result[$value['end_date']][$value['skill_name']] = $value["addition"];
                }
            } else {
                $result[$value['end_date']][$value['skill_name']] = $value["addition"];
            }
        }
        $skills1 = M('EmployeeDoTraining a')
                ->join("__TRAINING__ d on a.Training_ID=d.Training_ID")
                ->join("__TRAINING_INCLUDE_SKILL__ b on a.Training_ID=b.Training_ID")
                ->join("__SKILL__ c on b.Skill_ID=c.Skill_ID")
                ->where(array('a.Talent_ID' => $myInfo['talent_id']))
                ->select();
        $result1 = array();
        foreach ($skills1 as $value) {
            if (key_exists($value['end_date'], $result1)) {
                if (key_exists($value['skill_name'], $result1[$value['end_date']])) {
                    $result1[$value['end_date']][$value['skill_name']] = $result1[$value['end_date']][$value['skill_name']] + $value["addition"];
                } else {
                    $result1[$value['end_date']][$value['skill_name']] = $value["addition"];
                }
            } else {
                $result1[$value['end_date']][$value['skill_name']] = $value["addition"];
            }
        }
        foreach ($result1 as $key => $value) {
            if (key_exists($key, $result)) {
                foreach ($value as $key1 => $value1) {
                    if (key_exists($key1, $result[$key])) {
                        $result[$key][$key1] = $result[$key][$key1] + $value1;
                    } else {
                        $result[$key][$key1] = $value1;
                    }
                }
            } else {
                $result[$key] = $value;
            }
        }
        ksort($result);
        $add = array();
        foreach ($result as &$value3) {
            foreach ($value3 as $key => $value) {
                if (key_exists($key, $add)) {
                    $value3[$key] = $value + $add[$key];
                }
                $add[$key] = $value3[$key];
            }
        }
        foreach ($add as $key=>$value) {
            $add[$key]=0;
        }
        foreach ($result as $key => $value) {
                $result[$key]=$add=array_merge($add,$value); 
        }
        $this->assign('training', $training);
        $this->assign('trainingSelect1', $trainingSelect1);
        $this->assign('myInfo', $myInfo);
        $this->assign('project', $project);
        $this->assign('salary', $salary);
        $this->assign('add', $add);
        $this->assign('result', $result);
        $this->display();
    }

}
