<!--#include file="./easyasp/easp.asp" -->
<!--#include file="./connect.asp"-->

<%
Dim Json
Easp.Json.EncodeUnicode=false
Set Json = Easp.Json.NewObject

dim sortname,sortorder,sql
sortname=request("sortname")
sortorder=request("sortorder")

sql="select * from usertable"
if(sortname <>"" and sortorder <>"") then
sql=sql &" order by "&sortname&" "&sortorder
end if


rs.open sql,conn,1,1

'Json("Image") = Easp.Json.NewObject
'可以用下面这种方式直接设置 key/value
Json("Rows") = Easp.Json.NewArray
'数组可以直接向下标添加value
dim x,s,vals,i,page
dim pagesize
x=0


rs.PageSize=cint(request("pagesize")) 
'x=rs.PageCount '获取总页码 
page=cint(request("page")) '接收页码 
if page<=0 then page=1 '判断 
if request("page")="" then page=1 
rs.AbsolutePage=page


for i=1 to rs.PageSize
	if rs.eof then exit for
	s="Rows["&x&"]"
	Json(s) = Easp.Json.NewObject
	'response.write Json.ToString()
	Json(s&".userid")=rs("userid").value
	Json(s&".userpass")=rs("userpass").value
	Json(s&".username")=rs("username").value
	x=x+1	
	rs.movenext
next
'x=rs.recordcount

Json("count") = x
Json("Total") =rs.recordcount
rs.close
'Json("Rows[0]") = Easp.Json.NewObject
'也可以用下面的方式添加
'Json("Rows[0].userid") = "user1"
'Json("Rows[0].username") = "用户1"
'Json("Rows[0].userpass") = "pass"
'Json("Rows[1]") = Easp.Json.NewObject
'Json("Rows[1].userid") = "user2"
'Json("Rows[1].username") = "用户2"
'Json("Rows[1].userpass") = "pass"
'Json("count") = 2
'Easp.Println Json("Image.position[1].y")
'Json("Image.position[4]") = Empty
'Easp.Println Json.ToString()
Easp.Print Json.ToString()

Set Json = Nothing
%>
