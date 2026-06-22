@extends('layout.baseview')
@section('title','All Tasks')
@section('style')
<style>
    .done {
        text-decoration: line-through;
    }
</style>
 <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
@endsection
@section('content')
    @include('layout.navigation')
    <div class="container mt-5">
        <button type="button" class="btn btn-outline-primary mb-5 end-0" onclick="addtask()">Add Task</button>
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Si no</th>
                        <th scope="col">Task description</th>
                        <th scope="col">Task Owner</th>
                        <th scope="col">Task ETA</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody id="taskTable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="createTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="createTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="createTaskDescription" placeholder="Enter Task Description">
                        </div>
                        <div class="form-group">
                            <label for="createTaskOwner">Task Owner</label>
                            <input type="text" class="form-control" id="createTaskOwner" placeholder="Enter Task Owner">
                        </div>
                        <div class="form-group">
                            <label for="createTaskEmail">Task owner Email</label>
                            <input type="email" class="form-control" id="createTaskEmail" placeholder="Enter Task owner Email">
                        </div>
                        <div class="form-group">
                            <label for="createTaskEta">Task ETA</label>
                            <input type="date" class="form-control" id="createTaskEta" placeholder="Enter Task ETA">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="createTask()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="editTaskDescription">Task Description</label>
                            <input type="text" class="form-control" id="editTaskDescription" placeholder="Enter Task Description">
                        </div>
                        <div class="form-group">
                            <label for="editTaskOwner">Task Owner</label>
                            <input type="text" class="form-control" id="editTaskOwner" placeholder="Enter Task Owner">
                        </div>
                        <div class="form-group">
                            <label for="editTaskEmail">Task owner Email</label>
                            <input type="email" class="form-control" id="editTaskEmail" placeholder="Enter Task owner Email">
                        </div>
                        <div class="form-group">
                            <label for="editTaskEta">Task ETA</label>
                            <input type="date" class="form-control" id="editTaskEta" placeholder="Enter Task ETA">
                        </div>
                        <div class="form-group">
                            <label for="editTaskStatus">Task Status</label>
                            <select class="form-control" id="editTaskStatus">
                                <option>Set task status</option>
                                <option value="0">In Progress</option>
                                <option value="1">Completed</option>
                            </select>
                        </div>
                        <input type="hidden" id="editTaskid">
                    </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateTask()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="doneTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mark Task as Done</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to mark this task as done?</p>
                        <input type="hidden" id="doneTaskid">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateMarkAsDone()">Submit</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteTaskModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this task?</p>
                        <input type="hidden" id="deleteTaskid">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateTaskDelete()">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customjs')
<script>
    $(document).ready(function(){
        getAllTasks();
    });
    function getAllTasks(){
        $.ajax({
            type: 'get',
            url: 'http://localhost:8000/api/task',
            success: function(result){
                var html = '';
                for(var i=0; i<result.length; i++){
                    var linethrough = result[i]['task_status'] == 1 ? 'class="done"' : '';
                    html += '<tr>'
                         +'<th scope="row" '+linethrough+'>'+(i+1)+'</th>'
                         +'<td '+linethrough+'>'+result[i]['task_description']+'</td>'
                         +'<td '+linethrough+'>'+result[i]['task_owner']+'</td>'
                         +'<td '+linethrough+'>'+result[i]['task_eta']+'</td>'
                         +'<td>'
                            +'<button type="button" class="btn btn-outline-primary" onclick="editTask('+result[i].id+')">Edit</button>'
                            +'<button type="button" class="btn btn-outline-secondary" onclick="markAsDone('+result[i].id+')">Status</button>'
                            +'<button type="button" class="btn btn-outline-danger" onclick="deleteTask('+result[i].id+')">Delete</button>'
                            +'</td>'
                            +'</tr>';
                }
                $('#taskTable').html(html);
            },
            error: function(e){
                console.log(e.responseText);
            }
        })
    }
    function addtask(){
        $("#createTaskModal").modal('show');
    }
    function createTask(){
        var task_description = $('#createTaskDescription').val();
        var task_owner = $('#createTaskOwner').val();
        var task_owner_email = $('#createTaskEmail').val();
        var task_eta = $('#createTaskEta').val();
        $.ajax({
            type: 'post',
            url: 'http://localhost:8000/api/task',
            data: {
                task_description: task_description,
                task_owner: task_owner,
                task_owner_email: task_owner_email,
                task_eta: task_eta
            },
            success: function(result){
                $('#createModal').modal('hide');
                getAllTasks();
            },
            error: function(e){
                console.log(e.responseText);
            }
        })
    }
    function editTask(id){
    $.ajax({
        type: 'get',
        url: 'http://localhost:8000/api/task/' + id,
        success: function(result){
            $('#editTaskid').val(result.id);
            $('#editTaskDescription').val(result.task_description);
            $('#editTaskOwner').val(result.task_owner);
            $('#editTaskEmail').val(result.task_owner_email);
            $('#editTaskEta').val(result.task_eta);
            $('#editTaskStatus').val(result.task_status);
            $("#editTaskModal").modal('show');
        }
    });
}

  function updateTask(){
    var id = $('#editTaskid').val();
    var task_description = $('#editTaskDescription').val();
    var task_owner = $('#editTaskOwner').val();
    var task_owner_email = $('#editTaskEmail').val();
    var task_eta = $('#editTaskEta').val();
    var task_status = $('#editTaskStatus').val();

    $.ajax({
        type: 'put',
        url: 'http://localhost:8000/api/task/' + id,
        data: {
            task_description: task_description,
            task_owner: task_owner,
            task_owner_email: task_owner_email,
            task_eta: task_eta,
            task_status: task_status
        },
        success: function(result){
            $("#editTaskModal").modal('hide');
            getAllTasks();
        },
        error: function(e){
            console.log(e.responseText);
        }
    });
}
function markAsDone(id){
    $('#doneTaskid').val(id);
    $("#doneTaskModal").modal('show');
}
function updateMarkAsDone(){
    var id = $('#doneTaskid').val();
    $.ajax({
        type: 'post',
        url: 'http://localhost:8000/api/task/done/' + id,
        success: function(result){
            $("#doneTaskModal").modal('hide');
            getAllTasks();
        },
        error: function(e){
            console.log(e.responseText);
        }
    });
}
function deleteTask(id){
    $('#deleteTaskid').val(id);
    $("#deleteTaskModal").modal('show');
}
function updateTaskDelete(){
    var id = $('#deleteTaskid').val();
    $.ajax({
        type: 'delete',
        url: 'http://localhost:8000/api/task/' + id,
        success: function(result){
            $("#deleteTaskModal").modal('hide');
            getAllTasks();
        },
        error: function(e){
            console.log(e.responseText);
        }
    });
}
    </script>
    @endsection