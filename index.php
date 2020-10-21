<?php
$timeArray = [
    "8.00 AM" , "8.30 AM" , "9.00 AM" , "9.30 AM" , "10.00 AM" , "10.30 AM" , "11.00 AM" , "11.30 AM" , "12.00 AM" 
    , "12.30 AM" , "1.00 PM" , "1.30 PM" , "2.00 PM" , "2.30 PM" , "3.00 PM" , "3.30 PM" , "4.00 PM" , "4.30 PM" 
    , "5.00 PM" , "5.30 PM" , "6.00 PM"
]
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=3, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
    <title>Time Slot</title>
</head>
<body>
    

    <div class="text-center">
        <h1>Time Slot</h1>
        <div>
            <input placeholder= "Choose Date" type = 'date' id = 'chooseDate' />
            <button id = 'submitButton'>Check Time Slot</button>
            </div>

            <div id = 'tableTime' class = 'table mt-5' style = 'display: none;'>
            <?php foreach($timeArray as $item): ?>
                
                <button class = 'time-item'><?php echo $item; ?></button>

            <?php  endforeach; ?>
        </div>
    </div>

    <div id = 'notAvailable' style = 'display:none;' class = 'mt-5'>
        <p>Not available</p>
    </div>

    <div id="ex1" class="modal" style = 'width: 100%!important;'>
        <h6 id = 'timeslot'></h6>
        <?php
            $arr = [0,1,2,3,4,5,6,7,8,9];
            foreach($arr as $item):
        ?>
        <div style = 'display: inline-block'>
            <input class = 'lock-name' type ='text' placeholder= "Input Your Name To Lock Slot" />
            <button class = 'lock-slot'>Lock Slot</button>
        </div>
        <?php  endforeach; ?>
        <a href="#" rel="modal:close">Close</a>
    </div>
    <p style = 'display:none;'><a id = 'showModal' href="#ex1" rel="modal:open">Open Modal</a></p>

<script>
    $( document ).ready(function() {   
        $("#submitButton").click(function(){
            $("#notAvailable").hide()
            $("#tableTime").hide()
            const p = $("#chooseDate").val()
            if(p == '' || p == null){
                alert('Please choose a date')
                return
            }else{
                const date = new Date($("#chooseDate").val());
                var n = date.getDay();
                if(n == 0 || n == 6){
                    $("#notAvailable").show()
                }else{
                    $("#tableTime").show()               
                }
            }        
        });


        $(".time-item").click((e) => {     
            const ts = $('#timeslot').text(e.target.innerText)
            const c = $(".lock-name")
            const date = new Date($("#chooseDate").val())
            const b = getLocal()

            $.each( c, function( key, value ) {
                
                let bc = $(c[key])
                bc.val('')          
            });
            
           
            if(b.value){
                for(let i = 0; i <b.value.length; i++){
                    const m = new Date(b.value[i].date)
                    if(m.getTime() == date.getTime() && e.target.innerText == b.value[i].timeslot ){
                        $(c[i]).val(b.value[i].name)
                    }
                }                
                $('#showModal').click()
            } else {

                $('#showModal').click()

            }         
        });

        $(".lock-slot").click((e) => {
            const dValue = new Date($("#chooseDate").val())
            const name = e.target.previousElementSibling.value
            const ab = $('#timeslot').text();
            
            if(name == '' || name == null){
                alert("Please Input your name")
                return
            } else {
                
                let obj = {
                    date : dValue,
                    name: name,
                    timeslot: ab
                }
                setLocal(obj)
            }
           
        });


        function setLocal(input){
            var existing = localStorage.getItem("data");
            existing = existing ? JSON.parse(existing) : {};
            if(existing.value){
                existing.value.push(input)
            }else{
                existing['value'] = []
                existing.value.push(input)
            }
                       
            let d  =  JSON.stringify(existing)
            localStorage.setItem("data", d);
        }

        function getLocal(){
            var existing = localStorage.getItem("data");
            existing = existing ? JSON.parse(existing) : {};
            return existing;
        }
        
    });
</script>

</body>
</html>