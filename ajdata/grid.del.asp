<!--#include file="./easyasp/easp.asp" -->
<!--#include file="./connect.asp"-->
<%
Dim Json,sql,userid
Easp.Json.EncodeUnicode=false
Set Json = Easp.Json.NewObject
userid=request("id")
sql="delete from usertable"
if(userid ="" ) then
Json("status")="ERROR"
Json("reason")="id参数错误"
Easp.Print Json.ToString()
response.end
end if

sql= sql &" where userid in('"&userid&"')"
'response.write sql
conn.execute(sql)
Json("status")="OK"
Easp.Print Json.ToString()
Set Json = Nothing
%>