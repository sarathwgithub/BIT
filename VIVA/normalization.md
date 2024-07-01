Unnormalized Table
StudentID	StudentName	Courses
    ![image](https://github.com/sarathwgithub/BIT/assets/147220538/308f963a-d556-41a2-8e29-4c23193e9e11)
  
  In this table, the Courses column contains repeating groups (course information for each student) and non-atomic values (multiple pieces of information in a single column).

Step 1: First Normal Form (1NF)
To achieve 1NF, we need to ensure that each column contains atomic values and that there are no repeating groups. We can split the repeating groups into separate rows:
![image](https://github.com/sarathwgithub/BIT/assets/147220538/4fcbad58-3f3e-4d7d-9e21-e148107d4611)

Step 2: Second Normal Form (2NF)
To achieve 2NF, we need to remove partial dependencies. This means that all non-key attributes must be fully functionally dependent on the primary key. Here, the primary key is a composite key of (StudentID, CourseID).

We split the table into three separate tables to eliminate partial dependencies:
![image](https://github.com/sarathwgithub/BIT/assets/147220538/65153860-0320-4402-ba0a-6c24170c823c)

Step 3: Third Normal Form (3NF)
To achieve 3NF, we need to remove transitive dependencies. This means non-key columns must not depend on other non-key columns. In the Courses table, ProfessorName depends on ProfessorID, which is not the primary key. We will create a separate Professors table:

![image](https://github.com/sarathwgithub/BIT/assets/147220538/6756c659-1cfd-435a-980d-c2ead8593ba6)
![image](https://github.com/sarathwgithub/BIT/assets/147220538/a12e9149-96dc-4f96-a794-ad07467bccf3)

All non-key attributes are fully functionally dependent on the primary key.
There are no transitive dependencies.
Each table has a primary key, and non-key attributes depend only on the primary key.



