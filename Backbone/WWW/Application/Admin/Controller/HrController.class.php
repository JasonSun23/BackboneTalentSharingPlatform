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
class HrController extends AdminController {

    //put your code here
    public function index() {
        $this->meta_title = 'HR';
        $myInfo = M('Talent')->find(UID);
        $gender = C('Gender');
        $talentStatus = C('TalentStatus');
        $myInfo['gender_text'] = $gender[$myInfo['gender']];
        $myInfo['status_text'] = $talentStatus[$myInfo['status']];
        $kpiOrder1 = I('kpiOrder1', 0);
        switch ($kpiOrder1) {
            case 1:$kpiOrder1 = 'c.KPI_Period desc';
                break;
            case 2:$kpiOrder1 = 'c.KPI_Period';
                break;
            case 3:$skillOrder1 = 'rank desc';
                break;
            case 4:$skillOrder1 = 'rank';
                break;

            default:
                break;
        }
        $md_key = I('md_key', '');
        $md_keyMap = array();
        $company_id = '';
        if ($md_key != '') {
            $amd_key = explode('-', $md_key);
            $md_keyMap['a.Company_ID'] = $company_id = $amd_key[0];
            $md_keyMap['a.Deparment_ID'] = $amd_key[1];
        }
        $pd_key = I('pd_key', '');
        $pd_keyMap = array();
        if ($pd_key != '') {
            $pd_keyMap['c.KPI_Period'] = $pd_key;
        }
        $departmentInfo = M('Department a')
                ->join('__EMPLOYEE__ b on a.Deparment_ID=b.Department_ID and a.Company_ID=b.Company_ID')
                ->join("__KPI__ c on b.Talent_ID=c.Talent_ID")
                ->join("__COMPANY__ d on a.Company_ID=d.Company_ID")
                ->where(array_merge($md_keyMap, $pd_keyMap))
                ->field("d.Company_Name company,c.KPI_Period period,a.Department_Name department,count(*) count,avg(c.Score) avg,max(c.Score) max,min(c.Score) min")
                ->group("c.KPI_Period,a.Deparment_ID,a.Company_ID")
                ->order($kpiOrder1)
                ->select();

        if ($company_id) {
            $companyInfoMap = array();
            $companyInfoMap['a.Company_ID'] = $company_id;
            $companyInfo = M('Department a')
                    ->join('__EMPLOYEE__ b on a.Deparment_ID=b.Department_ID and a.Company_ID=b.Company_ID')
                    ->join("__KPI__ c on b.Talent_ID=c.Talent_ID")
                    ->join("__COMPANY__ d on a.Company_ID=d.Company_ID")
                    ->where(array_merge($companyInfoMap, $pd_keyMap))
                    ->field("d.Company_Name company,c.KPI_Period period,count(*) count,avg(c.Score) avg,max(c.Score) max,min(c.Score) min")
                    ->group("c.KPI_Period,a.Company_ID")
                    ->order($kpiOrder1)
                    ->select();
            $this->assign('companyInfo', $companyInfo);
        }

        $salary_pd = I('salary_pd', '');
        $salary_pdMap = array();
        if ($salary_pd != '') {
            $salary_pdMap['c.KPI_Period'] = $salary_pd;
        }
        $salary = M('Employee a')
                ->join("__POSITION__ b on a.Position_ID=b.Position_ID")
                ->join("__KPI__ c on a.Talent_ID=c.Talent_ID")
                ->join("__DEPARTMENT__ d on a.Department_ID=d.Deparment_ID and a.Company_ID=d.Company_ID")
                ->join("__COMPANY__ e on e.Company_ID=d.Company_ID")
                ->where(array_merge($salary_pdMap))
                ->field("c.KPI_Period period,e.Company_Name company,d.Department_Name department,sum(b.Base_Salary+c.Score/100*d.Bonus) sum,count(b.Base_Salary+c.Score/100*d.Bonus) count,max(b.Base_Salary+c.Score/100*d.Bonus) max,min(b.Base_Salary+c.Score/100*d.Bonus) min,avg(b.Base_Salary+c.Score/100*d.Bonus) avg")
                ->group("a.Company_ID,a.Department_ID,c.KPI_Period")
                ->select();
        $departmentSelect = M('Department a')->join("__COMPANY__ b on a.Company_ID=b.Company_ID")->select();
        $departmentSelect1 = M('Kpi a')->field("DISTINCT KPI_Period pd")->select();
        $status = I('status', 0);
        if ($status) {
            $hiring = M('Unemployment');
        } else {
            $hiring = M('Employee');
        }
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
                    $map['a.Xp'] = array('between','0,200');
                    break;
                case 2:
                    $map['a.Xp'] = array('between','200,400');
                    break;
                case 3:
                    $map['a.Xp'] = array('between','400,600');
                    break;
                case 4:
                    $map['a.Xp'] = array('between','600,800');
                    break;
                case 5:
                    $map['a.Xp'] = array('between','800,1001');
                    break;

                default:
                    break;
            }
        }
        $level_list = I('level_list', '');
        if ($level_list != '') {
            switch ($level_list) {
                case 1:
                    $map['a.Level'] = array('between','0,20');
                    break;
                case 2:
                    $map['a.Level'] = array('between','20,40');
                    break;
                case 3:
                    $map['a.Level'] = array('between','40,60');
                    break;
                case 4:
                    $map['a.Level'] = array('between','60,80');
                    break;
                case 5:
                    $map['a.Level'] = array('between','80,101');
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
        $mapSql=array();
        
        $sid_list = I('sid_list', '');
        if ($sid_list != '') {
            $mapSql['Skill_ID'] = $sid_list;
        }
        $sscore_list = I('sscore_list', '');
        if ($sscore_list != '') {
              switch ($sscore_list) {
                case 1:
                    $mapSql['Skill_Score'] = array('between','0,20');
                    break;
                case 2:
                    $mapSql['Skill_Score'] = array('between','20,40');
                    break;
                case 3:
                    $mapSql['Skill_Score'] = array('between','40,60');
                    break;
                case 4:
                    $mapSql['Skill_Score'] = array('between','60,80');
                    break;
                case 5:
                    $mapSql['Skill_Score'] = array('between','80,101');
                    break;

                default:
                    break;
            }
        }
        $list_buildSql1=M('TalentHaveSkill')->field('Talent_ID')->where($mapSql)->buildSql();
        if($mapSql){
            $map['_string']="a.Talent_ID in {$list_buildSql1}";
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
        $this->assign('departmentInfo', $departmentInfo);
        $this->assign('departmentSelect', $departmentSelect);
        $this->assign('departmentSelect1', $departmentSelect1);
        $this->assign('salary', $salary);
        $this->assign('myInfo', $myInfo);
        $this->assign('positionSelect', $positionSelect);
        $this->assign('sidSelect', $sidSelect);
        $this->display();
    }

}
