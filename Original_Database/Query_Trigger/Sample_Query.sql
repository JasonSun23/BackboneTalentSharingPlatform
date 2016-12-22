
#The individual ID for the log in people
UserID
#The ID of given company
GivenComID


#When a individual log in this system, he/she will see his/her personal information, such as Name, University...
select L_Name, M_Name, F_Name, SSN, Gender, DoB, University_Name, Degree, GPA
from Talent, Talent_GrdFm_University, University
where Talent.Talent_ID=Talent_GrdFm_University.Talent_ID 
		and Talent.Talent_ID=UserID 
		and University.University_ID=Talent_GrdFm_University.University_ID


#People can see the information of theri company.
select Company_Name, Department_Name,Street, City, Zip
from
((Employee join Department on Employee.Department_ID=Department.Deparment_ID) join Company on Company.Company_ID=Employee.Company_ID) 
where Talent_ID=UserID




#Individual's skills and rank in the whole backbone system. 

select A.Skill_Name,count(*)/5000 as Percentage
from
(
select Skill_Score,Skill_Name
from 
Skill join Talent_Have_Skill on Skill.Skill_ID=Talent_Have_Skill.Skill_ID
) A
JOIN
(
SELECT Skill_Name,Skill_Score
from Skill join Talent_Have_Skill on Skill.Skill_ID=Talent_Have_Skill.Skill_ID
where Talent_ID=UserID
) B
on A.Skill_Name=B.Skill_Name
where A.Skill_Score>B.Skill_Score
group by A.Skill_Name


#Individual's skills and rank in their own company. 
select C.Skill_Name, small/total as Percentage
FROM
(
(
select A.Skill_Name,count(*) as small
from
(
select Skill_Score,Skill_Name
from 
Skill join Talent_Have_Skill on Skill.Skill_ID=Talent_Have_Skill.Skill_ID
where Talent_ID in (
select Talent_ID
from Employee
where Company_ID=1
)
) A
JOIN
(
SELECT Skill_Name,Skill_Score
from Skill join Talent_Have_Skill on Skill.Skill_ID=Talent_Have_Skill.Skill_ID
where Talent_ID=541964
) B
on A.Skill_Name=B.Skill_Name
where A.Skill_Score>B.Skill_Score
group by A.Skill_Name
) C
join 
(
select count(*) as total,Skill_Name
from 
Skill join Talent_Have_Skill on Skill.Skill_ID=Talent_Have_Skill.Skill_ID
where Talent_ID in (
select Talent_ID
from Employee
where Company_ID=1
)
group by Skill_Name
) D
on C.Skill_Name=D.Skill_Name
)




#Training history of individual
select End_Date, Training_Name,Skill_Name,T_Grade
from 
((
select Training_ID,End_Date, Training_Name
from Trainning
where Training_ID in (select Training_ID from Employee_Do_Trainning where Talent_ID=UserID)
) A_1
join 
(
select Training_ID, T_Grade
from Employee_Do_Trainning
where Talent_ID=UserID
) A_2
on A_1.Training_ID=A_2.Training_ID
)
join
(
select Training_ID,Skill_Name
from
(select *
from Skill) A_3
join 
(select *
from Trainning_includ_Skill
where Training_ID in (select Training_ID from Employee_Do_Trainning where Talent_ID=UserID)
) A_4
on A_3.Skill_ID=A_4.Skill_ID
) A_5
on A_1.Training_ID=A_5.Training_ID


#Project history of individual

select End_Date, Project_Name,Skill_Name,P_Grade,Quality
from 
(((
select Project_ID,P_Grade
from Employee_WorkOn_Project
where Talent_ID=UserID
) A
join
(
select Project_ID, Project_Name, End_Date, Quality
from Project
where Project_ID in (select Project_ID from Employee_WorkOn_Project where Talent_ID=UserID)
) B 
on A.Project_ID=B.Project_ID
)
join 
Project_Include_Skill on Project_Include_Skill.Project_ID=A.Project_ID
join 
Skill 
ON Skill.Skill_ID=Project_Include_Skill.Skill_ID
)

# HR can see the department information of their company, including the information of KPI...
select Department_Name, TOP_KPI, BOTTOM_KPI, AVG_KPI
from
(
select Department_ID, max(Score) as TOP_KPI, min(Score) as BOTTOM_KPI, avg(Score) as AVG_KPI
from
(
select Department_ID, Talent_ID
from Employee 
where Company_ID=GivenComID and Department_ID in(
												select Department_ID
												from Department
 											where Company_ID=GivenComID)
) A
join
(
select F.Talent_ID,Score
from
((
select KPI.Talent_ID, max(KPI_Period) as KPI_Period
from KPI
group by KPI.Talent_ID) F
join 
KPI
on F.Talent_ID=KPI.Talent_ID and F.KPI_Period=KPI.KPI_Period)
)B
on A.Talent_ID=B.Talent_ID
group by Department_ID
) C
join
(
select Department_ID,Department_Name
from Department
where Company_ID=GivenComID
)D
on C.Department_ID=D.Department_ID



#HR can see the hiring information of people in this system, including their basic information and the gamification indicator like XP
select  Status, L_Name, M_Name, F_Name, SSN, Gender, DoB, University_Name,Degree,GPA,Skill_Name,Skill_Score,XP,Level
from
(((
select Talent_ID, Status, L_Name, M_Name, F_Name, SSN, Gender, DoB ,XP, Level
from Talent
) A
join
(
select Talent_ID, Skill_Name, Skill_Score
from 
(Skill join Talent_Have_Skill on Skill.Skill_ID=Talent_Have_Skill.Skill_ID)
) B
on A.Talent_ID=B.Talent_ID
)join(
select Talent_ID, University_Name, Degree, GPA
from
(University join Talent_GrdFm_University on University.University_ID=Talent_GrdFm_University.University_ID)
)C
on A.Talent_ID=C.Talent_ID
)


#Manager can see the basic information of the project in the company
select Project_Name, End_Date, Skill_Name, Quality, L_Name as Pro_Name
from
(Project 
join 
Project_include_Skill 
on Project.Project_ID=Project_include_Skill.Project_ID) 
join Skill 
on Project_include_Skill.Skill_ID=Skill.Skill_ID 
join  Talent
on Talent.Talent_ID=Project.Pro_Mgr_Talent_ID
join Employee
on Employee.Talent_ID=Talent.Talent_ID
where Company_ID=GivenComID

#Manager can see the basic information of the training in the company


SELECT L_Name as Name,Training_Name, End_Date, T_Grade
from
Talent 
join Employee_Do_Training 
on Employee_Do_Training.Talent_ID=Talent.Talent_ID 
join Training
on Training.Training_ID=Employee_Do_Training.Training_ID
join Employee
on Employee.Talent_ID=Talent.Talent_ID
where Company_ID=GivenComID

#Manager can see the hiring information of people in the company, including their basic information and the gamification indicator like XP
select  Status, L_Name, M_Name, F_Name, SSN, Gender, DoB, University_Name,Degree,GPA,Skill_Name,Skill_Score,XP,Level
from
(((
select Talent_ID, Status, L_Name, M_Name, F_Name, SSN, Gender, DoB ,XP, Level
from Talent
) A
join
(
select Talent_ID, Skill_Name, Skill_Score
from 
(Skill join Talent_Have_Skill on Skill.Skill_ID=Talent_Have_Skill.Skill_ID)
) B
on A.Talent_ID=B.Talent_ID
)join(
select Talent_ID, University_Name, Degree, GPA
from
(University join Talent_GrdFm_University on University.University_ID=Talent_GrdFm_University.University_ID)
)C
on A.Talent_ID=C.Talent_ID
)
join Employee
on Employee.Talent_ID=A.Talent_ID
where Company_ID=GivenComID



#Individual create account 
##Talent_ID is given
Insert into Talent(Talent_ID, SSN, L_Name, M_Name, ..)
values(value1,value2,...)

Insert into Talent_GrdFm_University(Talent_ID,University_ID,...)
values(value1,value2....)

Insert into Talent_Have_Skill(Talent_ID,Skill_ID,Skill_Score)
values(value1,value2,value3)

Insert into Unemployment(Talent_ID,Unemp_Start_Date)
values(value1,value2)


#Individual become employee
## We know the talent_ID
Insert into Employee(Talent_ID,Company_ID,...)
values(value1,value2...)

#finish a project
## We know the company and the set of Talent_ID
Insert into Project(Project_ID,Project_Name,...)
values(value1,value2....)


Insert into Project_Include_Skill(Skill_ID,Project_ID)
values(value1,value2)


Insert into Employee_WorkOn_Project(Talent_ID,Project_ID,P_Grade)
values(value1,value2,value3)



#finish a train

Insert into Trainning(Training_ID,Training_Name,End_Date)
values(value1,value2,value3)


Insert into Trainning_includ_Skill(Skill_ID,Training_ID)
values(value1,value2)


Insert into Employee_Do_Training (Talent_ID,Training_ID, T_Grade)
values(value1,value2,value3)



#增加新position
Insert into Position(Project_ID,Project_Name,End_Date,Quality,Pro_Mgr_Talent_ID)
values(value1,value2,value3,value4,value5)



#Company create 
##company_ID is given
Insert into Company(Company_ID,Company_Name,Type)
values(value1,value2,value3)


#Individual drop the system
Delete from Talent
where Talent_ID=UserID


Delete from Talent_GrdFm_University
where Talent_ID=UserID

Delete from Talent_Have_Skill
where Talent_ID=UserID

Delete from Unemployment
where Talent_ID=UserID

#Individual be fired

Delete from Employee
where Talent_ID=UserID


#Cancel a position

Delete from Position
where position_ID=Given_ID

#Company drop the system

Delete from Company
where Company_ID=GivenComID

