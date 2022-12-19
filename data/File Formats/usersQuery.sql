/****** Script for SelectTopNRows command from SSMS  ******/
SELECT TOP (1000) [id]
      ,[first_name]
      ,[last_name]
      ,[name]
      ,[username]
      ,[gender]
      ,[email]
      ,[department_id]
      ,[tel_no]
      ,[alt_telno]
      ,[address]
      ,[nationalID_no]
      ,[email_verified_at]
      ,[image]
      ,[password]
      ,[is_active]
      ,[inactivated_by]
      ,[remember_token]
      ,[created_at]
      ,[updated_at]
  FROM [posdb].[dbo].[users]

    UPDATE users SET password='$2y$10$WFuuNkT.xHbfXrHOmSiQEeXEU.rHa1HL8hw5YzD9v9Pg7LQKrf/d.',
  is_active=1 where id>0

    UPDATE users SET department_id=1 where id=1
	UPDATE users SET department_id=3 where id=3