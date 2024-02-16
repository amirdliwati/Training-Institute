angular.module('WaitingListApp.controllers',[]).controller('WaitingListCtrl', function ($scope,$http) {
    $scope.students = [];
    checkTableVisibility();
    $scope.fetchAllStudents = function(){

        $http.get("http://127.0.0.1/projects/icard_academy/index.php?r=student/RetrieveWaitingList&course_type_id="+$scope.course_type_id)
            .success(function(data){
                $scope.students = data;
            }
        );
        checkTableVisibility()
    }

    function checkTableVisibility(){
        if ($scope.students.length==0){
            $scope.tableClass="hidden";
        }else{
            $scope.tableClass="";
        }
    }
});

