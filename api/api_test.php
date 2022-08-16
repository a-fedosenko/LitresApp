<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=1428, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aligner Api test</title>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>  

  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

  
  <?=$favicon;?>
</head>
<body>
    
<div>
    
    <!-- Credentials -->
   
    <h3> API USER </h3>    
    <div style="display:flex;">
        <label>Email: </label>
        <input type="text" id="usermail" style="width:15%;"/>
        <label>Password: </label>
        <input type="password" id="userpass" style="width:15%;"/>
        <label>Host: </label>
        <input type="text" id="host" style="width:15%;"/>
    </div>
    
    
    
    <!-- GRABBER -->
    <h3> GRABBER </h3>

    <!-- Grab file -->
    <div style="display:flex;">
        <label>Grab File: </label>
        <input type="file" id="grabberfile" style="width:30%; border:solid 1px grey;"/>
        <label>Language: </label>
        <input type="text" id="filelang" style="width:5%;"/>
        <button onclick="grabFile()"> Send to Grabber </button>        
    </div>
    <div style="display:flex;">
        <p>Response: </p>
        <p id="grabberfileresp"></p>
    </div>      

    <!-- Grab URL -->
    <div style="display:flex;">
        <label>Grab URL: </label>
        <input type="text" id="grabberurl" style="width:20%;"/>
        <label>Recursive: </label>
        <input type="checkbox" id="recflag" style="width:2%; height:1rem;"/>
        <label>Language: </label>
        <input type="text" id="urllang" style="width:10%;"/>
       <button onclick="grabUrl()"> Send to Grabber </button>        
    </div>
    
    <div style="display:flex;">
        <p>Response: </p>
        <p id="grabberurlresp"></p>
    </div>        
    

    <!-- Grabber actions -->
    <h4> Actions </h4>
    <div style="display:flex;">     
        <label>Task ID: </label>
        <input type="text" id="grabberguid" style="width:20%;"/>
        <button onclick="checkTask('grabber')"> File status </button>        
        <button onclick="infoTask('grabber')"> File info </button>        
        <button onclick="getTask('grabber')"> Get file </button>        
        <button onclick="delTask('grabber')"> Delete file </button>        
    </div>
    
    <div style="display:flex;">
        <p>Response: </p>
        <p id="grabberactionresp"></p>
    </div>        
      
    
    <h3> ALIGNER </h3>

    <!-- Send file -->
    <div style="display:flex;">    
        <label>Source: </label>
        <textarea id="tasks1" style="width:20%; min-height:40px;"></textarea>
        <label>Target: </label>
        <textarea id="tasks2" style="width:20%; min-height:40px;"></textarea>
        <button onclick="alignTasks()"> Align Tasks </button>        
    </div>
    
    <div style="display:flex;">
        <p>Response: </p>
        <p id="alignertaskresp"></p>
    </div>        
    

    <!-- File actions -->
    <h4> Actions </h4>
    <div style="display:flex;">     
        <label>Task ID: </label>
        <input type="text" id="alignerguid" style="width:20%;"/>
        <button onclick="checkTask('aligner')"> File status </button>        
        <button onclick="infoTask('aligner')"> File info </button>        
        <button onclick="cleanTask(0.9995, 0.7000)"> Clean up file </button>        
        <button onclick="getTask('aligner')"> Get file </button>        
        <button onclick="delTask('aligner')"> Delete file </button>     
    </div>
    
    <div style="display:flex;">
        <p>Response: </p>
        <p id="aligneractionresp"></p>
    </div> 
    
    
    <h3> GENERAL </h3>

    <!-- Send file -->
    <div style="display:flex;">    
        <label>User: </label>
        <input type="text" id="user" style="width:20%;"/>
        <label>App: </label>
        <select id="app" style="width:5%;">
            <option value='grabber'>Grabber</option>
            <option value='aligner'>Aligner</option>
        </select>
        <label>Status: </label>
        <select id="status" style="width:5%;">
            <option value=''>All</option>
            <option value='3'>Reviewed</option>
            <option value='2'>Done</option>
            <option value='1'>Active</option>
            <option value='0'>Queued</option>
            <option value='-1'>Failed</option>
        </select>
        <button onclick="listTasks()"> List Tasks </button>     
    </div>
    
    <div style="display:flex;">
        <p>Response: </p>
        <p id="generalresp"></p>
    </div>   




</div>

<style>
div, h3, h4{
   
}    
input, button, label, div, 
p, h4, textarea, select  {
    margin-left:16px;    
}
button {
    height:1.5rem;    
}
</style>

<script>
//MAIN FUNCTIONS

function grabFile(){ 

    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        host = document.getElementById('host').value,
        lang = document.getElementById('filelang').value,
        resp = document.getElementById('grabberfileresp');

    resp.innerHTML = "";
    const file_node = document.getElementById('grabberfile'),
          file = file_node.files[0];
    const form_data = new FormData();
    form_data.append('grabber_file', file);
    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    
    form_data.append('source_lang',  lang);     

    fetch(host+"/api.php/grabber/file", {
        method:"POST",
        body: form_data
    }).then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = data.message;
        }
    );
}

function grabUrl(){ 
    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        host = document.getElementById('host').value,
        lang = document.getElementById('urllang').value,
        rec_flag = +document.getElementById('recflag').checked, //must be a number 0 or 1
        resp = document.getElementById('grabberurlresp');

    resp.innerHTML = "";
    const url = document.getElementById('grabberurl').value;
    const form_data = new FormData();
    form_data.append('url1', url);
    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    
    form_data.append('rec_flag', rec_flag);    
    form_data.append('source_lang',  lang);     

    fetch(host+"/api.php/grabber/url", {
        method:"POST",
        body: form_data
    }).then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = data.message;
            console.log(data)
        }
    );
}

function alignTasks(){ 

    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        host = document.getElementById('host').value,
        tasks1 = document.getElementById('tasks1').value,
        tasks2 = document.getElementById('tasks2').value,
        resp = document.getElementById('alignertaskresp');

    resp.innerHTML = "";
    const form_data = new FormData();
    form_data.append('guids1', tasks1);
    form_data.append('guids2', tasks2);
    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    

    fetch(host+"/api.php/aligner/tasks", {
        method:"POST",
        body: form_data
    }).then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = data.message;
        }
    );
}

//SUPPORT FUNCTIONS

function checkTask(app){ 

    let guid = document.getElementById(app+'guid').value,
        host = document.getElementById('host').value,
        resp = document.getElementById(app+'actionresp'); 

    fetch(host+"/api.php/"+app+"/status/" + guid, {
        method:"GET"
    }).then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = "Status: " + data.message + " (" + statusName(data.message) + ")";
        }
    );
}

function infoTask(app){ 

    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        guid = document.getElementById(app+'guid').value,
        host = document.getElementById('host').value,
        resp = document.getElementById(app+'actionresp'); 
    
    const form_data = new FormData();

    form_data.append(app+'guid', guid);
    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    

    fetch(host+"/api.php/"+app+"/info", {
        method:"POST",
        body: form_data
    }).then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = JSON.stringify(data.message);
        }
    );
}

function getTask(app){ 
    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        host = document.getElementById('host').value,
        guid = document.getElementById(app+'guid').value,
        resp = document.getElementById(app+'actionresp');

    const form_data = new FormData();

    form_data.append(app+'guid', guid);
    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    

    fetch(host+"/api.php/"+app+"/get", {
        method:"POST",
        body: form_data
    })
    .then( res =>{
        const contentType = res.headers.get("content-type");
        if(contentType.startsWith('text')){
            return res.json();
        } else {
            return res.blob();
        }
    }).then(data=>{
        if(data.code){
            resp.innerHTML = data.message;
        } else {
            let a = document.createElement("a");
            a.href = window.URL.createObjectURL(data);
            a.download = guid + ".xlsx";
            a.click();
            resp.innerHTML = "File was downloaded"
        }
    });   
}

function delTask(app){ 
    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        host = document.getElementById('host').value,
        guid = document.getElementById(app+'guid').value,
        resp = document.getElementById(app+'actionresp');

    const form_data = new FormData();

    form_data.append(app+'guid', guid);
    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    

    fetch(host+"/api.php/"+app+"/delete", {
        method:"POST",
        body: form_data
    })
    .then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = data.message;
        }
    );   
}

function cleanTask(high, low){ 
    let app = "aligner";
    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        host = document.getElementById('host').value,
        guid = document.getElementById(app+'guid').value,
        resp = document.getElementById(app+'actionresp');

    const form_data = new FormData();

    form_data.append(app+'guid', guid);
    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    
    form_data.append('high', high);    
    form_data.append('low', low);    

    fetch(host+"/api.php/"+app+"/clean", {
        method:"POST",
        body: form_data
    })
    .then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = data.message;
        }
    );   
}

function listTasks(){ 
    let email = document.getElementById('usermail').value,
        pass = document.getElementById('userpass').value,
        host = document.getElementById('host').value,
        user = document.getElementById('user').value,
        app = document.getElementById('app').value,
        status = document.getElementById('status').value,
        resp = document.getElementById('generalresp');

    const form_data = new FormData();

    form_data.append('usermail', email);    
    form_data.append('userpass', pass);    
    form_data.append('user', user);
    form_data.append('app', app);
    form_data.append('status', status);

    fetch(host+"/api.php/"+app+"/list", {
        method:"POST",
        body: form_data
    })
    .then(function(response){
        return response.json();
    }).then(
        function(data){
            resp.innerHTML = JSON.stringify(data.message);
        }
    );   
}

function statusName(status){
    switch(status){
        case "0":
            return "Queued";
        case "1":
            return "Active";
        case "2":
            return "Finished";
        case "3":
            return "Reviewed";
        case "-1":
        case "-2":
        case "-3":
        case "-4":
            return "Failed";
    }
    return "None";
}

</script>

</body>
</html>