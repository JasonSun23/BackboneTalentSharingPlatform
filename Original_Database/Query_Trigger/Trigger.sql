#We can use:
SET FOREIGN_KEY_CHECKS=0;
#to ban the foreigner key yueshu and to recover it.

SET SQL_SAFE_UPDATES = 0; 
#to resolve the error 1175



#Delete all talent Xís data
    SET FOREIGN_KEY_CHECKS=0; # to cancel the foreign key constraint
SET SQL_SAFE_UPDATES = 0; # to avoid the error 1175
DELIMITER $
CREATE TRIGGER `delete_talent` AFTER DELETE ON `talent` FOR EACH ROW begin
   DELETE FROM talent_grdfm_university WHERE talent_grdFm_university.`Talent_ID` NOT IN (SELECT talent.`Talent_ID` FROM talent);
   DELETE FROM talent_have_skill WHERE talent_have_skill.`Talent_ID` NOT IN (SELECT talent.`Talent_ID` FROM talent);
END$
DELIMITER ;

#When insert a new talent data, we not only insert the data in table ëtalentí, but also in table  ëtalent_grdfm_universityí and ëtalent_have_skillí. Otherwise before we do the insert we will find whether thereís a same Talent_Id exists before.
DELIMITER $
create trigger insert_talent after insert on `talent` for each row begin
    IF (new.`Talent_ID` not IN (SELECT Talent_ID FROM `talent_grdfm_university`))
    THEN    
        insert into `talent_grdfm_university` VALUES(new.`Talent_ID`, 0, 9, 0);
    end if;
    IF (new.`Talent_ID` not IN (SELECT Talent_ID FROM `talent_have_skill`))
    THEN
        insert into `talent_have_skill` VALUES(new.`Talent_ID`,0,0);
    end if;
END$
DELIMITER ;

# A employee will get extra score after complishing a training
    SET FOREIGN_KEY_CHECKS=0; # to cancel the foreign key constraint
SET SQL_SAFE_UPDATES = 0; # to avoid the error 1175
DELIMITER $
create trigger train_score after insert on `employee_do_training` 
for each row begin
    update `talent_have_skill` SET 
    talent_have_skill.Skill_Score=talent_have_skill.Skill_Score+new.T_Grade*(SELECT distinct training_include_skill.Addition
    from `training_include_skill` 
    JOIN `employee_do_training` ON 
    new.Training_ID=project_include_skill.Training_ID) 
    WHERE talent_have_skill.Talent_ID=new.Talent_ID AND 
    talent_have_skill.Skill_ID in 
    (select training_include_skill.Skill_ID from `training_include_skill` 
    JOIN `employee_do_training` ON 
    new.Training_ID=training_include_skill.Training_ID);
END$
DELIMITER ;



#A employee will get extra score after doing project
SET FOREIGN_KEY_CHECKS=0; # to cancel the foreign key constraint
SET SQL_SAFE_UPDATES = 0; # to avoid the error 1175
DELIMITER $
create trigger project_score after insert on `employee_workon_project` 
for each row begin
    update `talent_have_skill` SET
talent_have_skill.Skill_Score=talent_have_skill.Skill_Score+new.P_Grade*(SELECT distinct project_include_skill.Addition
    from `project_include_skill` 
    JOIN `employee_workon_project` ON 
    new.Project_ID=project_include_skill.Project_ID)
    WHERE talent_have_skill.Talent_ID=new.Talent_ID AND 
    talent_have_skill.Skill_ID in 
    (select project_include_skill.Skill_ID from `project_include_skill` 
    JOIN `employee_workon_project` ON 
    new.Project_ID=project_include_skill.Project_ID);
END$
DELIMITER ;
