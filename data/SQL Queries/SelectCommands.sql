/****** Script for SelectTopNRows command from SSMS  ******/
SELECT TOP (1000) [id]
      ,[chat_command]
      ,[chat_response]
  FROM [posdb].[dbo].[chatbox]