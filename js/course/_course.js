function updateCourseStatus(t){t&&$.ajax({url:courseInfo.alterCourseStatusUrl,type:"POST",data:{cId:t.course_id,status:t.status},success:function(t,e,s){vex.dialog.alert("تمت اضافة العملية بنجاح")}})}var courseViewUpdate=function(){courseInfo.isStudentListAvailable||($("#students-tab").parent().addClass("disabled"),$("#students-tab").click(function(t){showMessage("لايوجد طلاب في الدورة")})),$("#updateCourseFormModal").modal("hide"),$.ajax({url:courseInfo.courseUpdateViewLink,type:"GET",dataType:"json",success:function(t,e,s){t.success&&($("#courseName").html(t.name),$("#courseDescription").html(t.description),$("#courseStatus").html(t.status),$("#courseCost").html(t.cost),$("#startDate").html(t.startDate),$("#endDate").html(t.endDate),$("#note").html(t.note),$("#currentProfits").html(t.currentProfits),$("#estimatedProfits").html(t.estimatedProfits))}})};$("#updateCourse").on("click",function(t){$.ajax({url:courseInfo.courseUpdateLink,type:"GET",success:function(t,e,s){$("#updateCourseFormModal .modal-body").html(t),$(".ok-sign").hide(),$(".error-sign").hide()},beforeSend:function(t,e){$("#updateCourseFormModal .modal-body").html("الرجاء الانتظار ..."),$("#updateCourseFormModal").modal("show")}})});var studentId=0,colorEffectedRow=function(){$("tr[student_id="+studentId+"]").addClass("highlighting")};$(function(){$(".Tabled table").addClass("table"),$(".Tabled table").addClass("subtable"),$(".tooltip-btn").hover(function(t){$(this).tooltip({animation:!0})})});