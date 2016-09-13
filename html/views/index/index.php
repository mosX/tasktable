 <style>
            #calendar{
                display: inline-block;
                margin:auto;
            }
        </style>
        <script>
            $('document').ready(function(){
                /*$('#calendar .day').click(function(){
                    console.log('click');
                    
                });*/
                                
                $('#date_btn').click(function(){              
                    var d = $$("calendar1").getSelectedDate();
                    console.log(d);
                    
                    
                    var year = d.getYear()+1900;
                    var month = d.getMonth()+1;
                    var day = d.getDate();
                    console.log(year + ' - '+ month + ' - '+ day);
                    
                    
                    
                    //console.log($$("calendar1").getVisibleDate());
                    
                    location.href = '/tasks/add/?year='+year+'&month='+month+'&day='+day;
                });
            });
        </script>
        
        <div class="container text-center" style="height:500px;">
            <div id="calendar" style=""></div>
            <div>
                <div id="date_btn" class="btn btn-primary">Выбрать</div>
            </div>
        </div>
        <script>
            var arr = new Array();
            <?php foreach($this->m->data as $item){ ?>
                arr.push(<?=$item->timestamp?>);
            <?php } ?>
            
        </script>
        
        <script>
            webix.Date.isHoliday = function(day){
                day = day.getDay();
                if (day === 0 || day == 6) return "webix_cal_event"; 
            };
            webix.Date.startOnMonday = true;
            
            
            
            webix.ui({
                    container:"calendar",
                    weekHeader:true,
                    date:new Date(2016,3,16),
                    view:"calendar",
                    id:"calendar1",
                    $init: function(){
                        console.log('dfsdfsdf');
                    },
                    
                    events:webix.Date.isHoliday,
                    on:{
                        onItemClick: function(){
                            alert("you have clicked an item");
                        }
                        
                    },
                    
                    dayTemplate: function(date){
                        var d,year,month,day;
                        for(var key in arr){
                            d = new Date(arr[key]*1000);
                            
                            year = d.getYear();
                            month = d.getMonth();
                            day = d.getDate();
                            
                            if(date.getDate() == day && date.getMonth() == month && date.getYear() == year){
                                var html = "<div class='day' style='color: red;font-weight:bolder;'>"+date.getDate()+"</div>";    
                                return html;
                            }
                        }
                                
                        var html = "<div class='day'>"+date.getDate()+"</div>";    
                        return html;
                    },
                    //timepicker:true,
                    width:500,
                    height:500
            });
            
            
            /*$$("calendar1").attachEvent("onItemClick", function(){
                console.log('1111');
                //$$("dtree").closeAll();
            });

            $$("calendar1").attachEvent("onItemClick", function(id, e, node){
                //var item = this.getItem(id);
                console.log('1111');
            });*/
        </script>
        
            