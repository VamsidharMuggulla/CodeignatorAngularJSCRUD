<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><html ng-app="app">
<head>
<title>Todo</title>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<style type="text/css">
.none{display: none;}
</style>
</head>
<body ng-controller="todo_controller">
<h1 class="panel-heading">Todo &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" class="glyphicon glyphicon-plus" onClick="$('.formData').slideToggle();"></a><span>
</h1>
<div class="alert alert-danger none"><b class="text-center"></b></div>
<div class="alert alert-success none"><b class="text-center"></b></div></span>
     <div class="panel-body none formData">
                <form class="form" name="todoForm">                    
                    <div class="form-group">
                        <label>Todo</label>
                        <input type="text" class="form-control" name="todo" ng-model="tempTodoData.todo"/>
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" name="description" ng-model="tempTodoData.description"/>
                    </div>
                    <div class="form-group">
                        <label>Date</label>        
                        <div class="input-append date" id="dp" data-date-format="yyyy-mm-dd">
  				<input class="form-control" name="date" ng-model="tempTodoData.date"/>
  					<span class="add-on"><i class="icon-th"></i></span>
					</div>
                    </div>                    
                    <a href="javascript:void(0);" class="btn btn-warning" onClick="$('.formData').slideUp();">Cancel</a>
			<a href="javascript:void(0);" class="btn btn-success" ng-hide="ok" ng-click="addTask()">Add Task</a>
                    <a href="javascript:void(0);" class="btn btn-success" ng-hide="!tempTodoData" ng-click="updateTask()">Update Task</a>
                </form>
            </div>
<div class="col col-md-6">
<h3>To List</h3>
<p ng-show="!taskss.length">Nothing Here!!</p>
<table class="table table-bordered table-striped table-hover" ng-hide="!taskss.length">
<thead>
	<tr>
		<th>To</th>
		 <th>Description</th>
		 <th>Date</th>
		 <th>Status</th>
		 <th>Actions</th>
	<tr>
	</thead>	
	<tbody ng-repeat="task in taskss = (tasks| filter:{status:0})"> 		
	<td>{{task.todo}}</td>
	<td>{{task.description}}</td>
	<td>{{ task.date = (task.date | date:'yyyy-MM-dd') }}</td>		
	<td> <input type="checkbox" ng-model="status" value="status" ng-change="setStatus(status,task)" />&nbsp;&nbsp;&nbsp;{{ task.status | filterIt}} 
	</td>
	<td class="text-center"><a href="javascript:void(0);" class="glyphicon glyphicon-edit" ng-click="editTask(task)"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0);" class="glyphicon glyphicon-trash" ng-click="deleteTask(task)"></a></td>
	</tbody>
</table>
</div>
<div class="col col-md-6">
<h3>Do List</h3>
<table class="table table-bordered table-striped table-hover" ng-hide="!tas.length">
<thead>
	<tr>	
		<th>Do</th>
		 <th>Description</th>
		 <th>Date</th>
		 <th>Status</th>
		 <th>Actions</th>
	<tr>	
</thead>
	<tbody ng-repeat="task in tas = (tasks| filter:{status:1})">		
	<p ng-show="!tas.length">Nothing here!!</p>	
	<td>{{task.todo}}</td>
	<td>{{task.description}}</td>
	<td>{{task.date | date:'yyyy-MM-dd' }}</td>		
	<td> <input id='ok' type="checkbox" ng-model="task.status" value="task.status" ng-change="setStatus(status,task)" />&nbsp;&nbsp;&nbsp;{{ task.status | filterIt}} </td>
	<td class="text-center"><a href="javascript:void(0);" class="glyphicon glyphicon-edit" ng-click="editTask(task)"></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="javascript:void(0);" class="glyphicon glyphicon-trash" ng-click="deleteTask(task)"></a></td>
	</tbody>	
</table>
</div>
 <script src = "https://ajax.googleapis.com/ajax/libs/angularjs/1.5.7/angular.min.js"></script> 
 <script type="text/javascript">
 	var app=angular.module('app',[]);
 	app.controller('todo_controller',function($scope,$http,$log,$filter){
 			$scope.tempTodoData = {};

 			$scope.addTask = function(){
        		$scope.saveTask('add');
        		  $('.formData').slideDown();
    		};
   
    		$scope.editTask = function(task){
        		$scope.tempTodoData = {            		
        			id:task.id,
            		todo:task.todo,
            		description:task.description,
            		date:task.date,            		
        		};
        		$scope.ok={}
        		$scope.index = $scope.tasks.indexOf(task);
        		$('.formData').slideDown();
    		};
    		$scope.updateTask = function(){
      			  $scope.saveTask('edit');      			  
    		};
    		 $scope.saveTask = function(type){
    			    var data = $.param({
            			'data':$scope.tempTodoData,            			
            			'type':type
        			});        			
        			$http.post("add_task", data).success(function(response){        				
            			if(response > 0){	            				
                			if(type == 'edit'){                    			                     			 
                    			$scope.tasks[$scope.index].title = $scope.tempTodoData.title;
             			         $scope.tasks[$scope.index].description = $scope.tempTodoData.description;
                      			$scope.tasks[$scope.index].date = $scope.tempTodoData.date;                    			$scope.messageSuccess('Task Updated Successfully!!');
                			}
                			else {                				
                    			$scope.tasks.push({                        			
                        			todo:$scope.tempTodoData.todo,
                        			description:$scope.tempTodoData.description,
                        			date:$scope.tempTodoData.date,
                        			status:0
                    			});                    
                    			$scope.messageSuccess('Task Created Successfully!!');
            			    }            			    
                			$scope.todoForm.$setPristine();
                			$scope.tempTodoData = {};
                			$('.formData').slideUp();                			
            			}
            			else {
                			$scope.messageError('Something Went Wrong Try Later.');
            			}
        			});
    			};   
    		$scope.deleteTask = function(task)	{
      	  			var conf = confirm('Are you sure to delete this Task?');
        			if(conf === true){
            			var data = $.param({
                			'id': task.id,                			
                			'type':'delete'
            			});            			
            			$http.post("add_task",data).success(function(response){
                				if(response ==1 ){
                    				var index = $scope.tasks.indexOf(task);
                    				$scope.tasks.splice(index,1);
                    				$scope.messageSuccess('Task Deleted Successfully!!');
                				}
                				else {
                    				$scope.messageError('Error deleting task, try again.');
                				}
            			});
        			}
    		};

 			$scope.tasks=[];
 			$http.get('get_tasks').success(function(data){
 				$scope.tasks=data;
 			});
 			$scope.setStatus = function(value,task){      	 			
 				if(value==false) { 					
 					var data = $.param({
                			'id': task.id,
                			'status': value
            		}); 					
 				}
 				else {
 					var data = $.param({
                			'id': task.id,
                			'status': value                		
            		}); 					
 				}
 				$http.post("set_status",data).success(function(response){ 						 					
                    		if(response==1)                    			
                    			task.status = 1
                    		else
                    			task.status = 0
            		});      				
		    };		    
    $scope.messageSuccess = function(msg){
        $('.alert-success > b').html(msg);
        $('.alert-success').show();
        $('.alert-success').delay(5000).slideUp(function(){
            $('.alert-success > b').html('');
        });
    };       
    $scope.messageError = function(msg){
        $('.alert-danger > b').html(msg);
        $('.alert-danger').show();
        $('.alert-danger').delay(5000).slideUp(function(){
            $('.alert-danger > b').html('');
        });
    };
 	}); 	 	
 	 	app.filter('filterIt', function() {
 		return function(x){
 			x=x==1?'Done':'Todo'
 			return x
 		};
 	});

 </script> 
 <script type="text/javascript">
	
	$('#dp').datepicker();
</script>

</body>
</html>