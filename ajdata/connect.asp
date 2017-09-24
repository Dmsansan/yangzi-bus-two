<%
dim SQL_TYPE,SQL_HOST
SQL_TYPE="ACCESS"
SQL_HOST=""
dim conn,connstr,startime,db,rs,rs1,rs_s,rs_s1,DataCon
	
Set conn = Server.CreateObject("ADODB.Connection")
Set Rs      = Server.CreateObject("ADODB.Recordset")
Set Rs1      = Server.CreateObject("ADODB.Recordset")
connstr ="provider=microsoft.ACE.oledb.12.0;data source=" &server.mappath("/ajdata/data/db20151026.accdb")
conn.Open connstr

If Err Then
      Err.Clear
      conn.close
      Set conn = Nothing
      Response.Write "数据库连接出错，请检查连接字串。"
      Response.End
End If


Set rs=Server.CreateObject("ADODB.RECORDSET")
Set rs1=Server.CreateObject("ADODB.RECORDSET")

'字母与数字


%>
