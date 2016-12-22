<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of MyInfoController
 *
 * @author wc
 */
class MyInfoController extends AdminController {

    //MyInfo List
    public function index() {
        $this->meta_title = 'My Info';
        $myInfo = M('Talent')->find(UID);
        $university=M('TalentGrdfmUniversity a')->join('__UNIVERSITY__ b on a.University_ID=b.University_ID')->where(array('a.Talent_ID'=>$myInfo['talent_id']))->find();
        
        $skillOrder1=I('skillOrder1',0);
        switch ($skillOrder1) {
            case 1:$skillOrder1='a.Skill_Score desc';
                break;
            case 2:$skillOrder1='a.Skill_Score';
                break;
            case 3:$skillOrder1='rank desc';
                break;
            case 4:$skillOrder1='rank';
                break;

            default:
                break;
        }
        $employee=M('Employee')->where(array('Talent_ID'=>$myInfo['talent_id']))->find();
        if(!$employee){
            $position=array();
            $company=array();
            $myColleage='';
        }  else {
            $position=M('Position')->where(array('Position_ID'=>$employee['position_id']))->find();
            $company=M('Department a')->join('__COMPANY__ b on a.Company_ID=b.Company_ID')->where(array('a.Deparment_ID'=>$employee['department_id']))->find();
            $myColleage=M('Employee')->field('Talent_ID')->where(array('Company_ID'=>$employee['company_id']))->buildSql();
            
            //company
           $buildKpiCount2=M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string'=>"c.Talent_ID in {$myColleage} and c.KPI_Period=a.KPI_Period"))->buildSql();
           $buildKpiCount3=M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string'=>"c.Talent_ID in {$myColleage} and c.KPI_Period=a.KPI_Period and c.Score>a.Score"))->buildSql();
           //Salary
           $salary=M('Employee a')
                   ->join("__POSITION__ b on a.Position_ID=b.Position_ID")
                   ->join("__KPI__ c on a.Talent_ID=c.Talent_ID")
                   ->join("__DEPARTMENT__ d on a.Department_ID=d.Deparment_ID and a.Company_ID=d.Company_ID")
                   ->where(array('a.Talent_ID'=>$employee['talent_id']))
                   ->order('c.KPI_Period desc')
                   ->field("*,b.Base_Salary+c.Score/100*d.Bonus salary")
                   ->find();
            $salary_b=M('kpi c')
                   ->join("__EMPLOYEE__ a on a.Talent_ID=c.Talent_ID  and c.KPI_Period='{$salary['kpi_period']}'")
                   ->join("__POSITION__ b on a.Position_ID=b.Position_ID")
                   ->join("__DEPARTMENT__ d on a.Department_ID=d.Deparment_ID and a.Company_ID=d.Company_ID")
                   ->field("count(*) a,count(case when b.Base_Salary+c.Score/100*d.Bonus>{$salary['salary']} then 1 else null end) b")
                   ->find();
            $salary_c=M('kpi c')
                   ->join("__EMPLOYEE__ a on a.Talent_ID=c.Talent_ID  and c.KPI_Period='{$salary['kpi_period']}'")
                   ->join("__POSITION__ b on a.Position_ID=b.Position_ID")
                   ->join("__DEPARTMENT__ d on a.Department_ID=d.Deparment_ID and a.Company_ID=d.Company_ID")
                   ->field("count(*) a,count(case when b.Base_Salary+c.Score/100*d.Bonus>{$salary['salary']} then 1 else null end) b")
                   ->where(array('_string'=>"c.Talent_ID in {$myColleage}"))
                   ->find();
            $salary['rank_b']=round((1-$salary_b['b']/$salary_b['a'])*100,2);
            $salary['rank_c']=round((1-$salary_c['b']/$salary_c['a'])*100,2);
        }
        $in_bc=I('in_bc','');
        $buldSqlFilter='';
        $buldSqlFilter.='Skill_ID=a.Skill_ID and Skill_Score>a.Skill_Score ';
        if($in_bc!=''){
            $buldSqlFilter.="and Talent_ID in {$myColleage}";
        }
        $buildSql=M('TalentHaveSkill')->where($buldSqlFilter)->field('count(*)')->buildSql();
        $skillMap=array();
        $skillMap['Talent_ID']=$myInfo['talent_id'];
        $skill=M('TalentHaveSkill a')->join('__SKILL__ b on a.Skill_ID=b.Skill_ID')
//                ->field('*,(select count(*)  from '.C('DB_PREFIX').'talent_have_skill where Skill_ID=a.Skill_ID and Skill_Score>a.Skill_Score) as rank')
                ->field('*,'.$buildSql.' rank')
                ->where($skillMap)->order($skillOrder1)->select();
        $kpiMap=array();
        $kpiMap['a.Talent_ID']=$myInfo['talent_id'];
        //backbone
        $buildKpiCount=M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string'=>'c.KPI_Period=a.KPI_Period'))->buildSql();
        $buildKpiCount1=M('Kpi c')->join("__EMPLOYEE__ d on c.Talent_ID=d.Talent_ID ")->field("count(DISTINCT(c.Talent_ID))")->where(array('_string'=>'c.KPI_Period=a.KPI_Period and c.Score>a.Score'))->buildSql();
       
        $kpiField="*,{$buildKpiCount} c,{$buildKpiCount1} c1";
        if($employee){
            $kpiField.=",{$buildKpiCount2} c2,{$buildKpiCount3} c3";
        }
        $kpi=M('Kpi a')->field($kpiField)->where($kpiMap)->order('a.KPI_Period desc')->find();
        if($kpi){
            $kpi['rank_b']=round((1-$kpi['c1']/$kpi['c'])*100,2);
        }
        
        if($employee){
            $kpi['rank_c']=round((1-$kpi['c3']/$kpi['c2'])*100,2);
        }
        $aveskill=M('Talent')->field('Avg(J) j,Avg(E) e,Avg(T) t,Avg(S) s,Avg(I) i,Avg(N) n,Avg(F) f,Avg(P) p')->find();
//        foreach ($skill as $key => &$value) {
//            $map=array('Skill_ID'=>$value['skill_id'],'Skill_Score'=>array('gt',$value['skill_score']));
//            //in_company
//            $value['rank']=M('TalentHaveSkill')->where($map)->count();
//        }
        $gender=C('Gender');
        $degree=C('Degree');
        $talentStatus=C('TalentStatus');
        $myInfo['gender_text']=$gender[$myInfo['gender']];
        $university['degree_text']=$degree[$university['degree']];
        $myInfo['status_text']=$talentStatus[$myInfo['status']];
        $this->assign('myInfo', $myInfo);
        $this->assign('university', $university);
        $this->assign('position', $position);
        $this->assign('company', $company);
        $this->assign('skill', $skill);
        $this->assign('aveskill', $aveskill);
        $this->assign('kpi', $kpi);
        $this->assign('salary', $salary);
        $this->display();
    }

}
