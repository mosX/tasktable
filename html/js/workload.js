function Workload(obj){
    //console.log(obj);
            this.parent = obj.parent;
            try{
                this.workloads = JSON.parse(obj.workloads);
            }catch(e){
                return false;
            }
            
            this.ws = $(this.parent)[0];
            this.ctx = this.ws.getContext('2d');
            
            this.ws.width = $('#canvas').width();
            this.ws.height = $('#canvas').height();
            
            this.start_day = obj.start_day-1;
            
            this.end_day = obj.end_day;
            
            
            this.x_margin = 20;
            this.y_margin = 20;
            this.width = this.ws.width - this.x_margin*2;
            this.height = 7;
            
            this.interval = this.end_day - this.start_day;
            
            this.dayLine();
            this.hourPositions();
            
            for(var key in this.workloads){                
                this.setWorkloads(this.workloads[key]);
            }
        }
        Workload.prototype = {
            parent:null,
            ws:null,ctx:null,
            start_day:0,end_day:0,
            interval:0,
            setWorkloads:function(data){                
                var start = data[0]-this.start_day;
                var end = data[1]-this.start_day;
                                
                var start_x = this.timeToX2(start);
                var end_x = this.timeToX2(end);
                
                this.ctx.save();
                    this.ctx.lineWidth = 5;
                    this.ctx.strokeStyle = 'red';

                    this.ctx.beginPath();
                        this.ctx.moveTo(this.x_margin+start_x, this.y_margin+4);
                        this.ctx.lineTo(this.x_margin+end_x, this.y_margin+4);
                    this.ctx.closePath();

                    this.ctx.stroke();
                this.ctx.restore();
            },
            dayLine:function(){
                this.ctx.save();
                    this.ctx.fillStyle = 'rgba(0,155,100,0.5)';
                    this.ctx.rect(this.x_margin,this.y_margin,this.width,this.height);
                    this.ctx.fill();
                this.ctx.restore();
            },
            hourPositions:function(){
                var start = 0;
                
                while(start <= this.interval){
                    var x = this.timeToX(start);
                    
                    this.ctx.save();
                        this.ctx.lineWidth = 1;
                        this.ctx.strokeStyle = '#5ca905';

                        this.ctx.beginPath();
                            this.ctx.moveTo(this.x_margin+x , this.y_margin);
                            this.ctx.lineTo(20+x, this.y_margin - 10);
                        this.ctx.closePath();

                        this.ctx.stroke();
                    this.ctx.restore();
                    
                    
                    var d = new Date( (this.start_day+start +1) *1000);
                    var hours = d.getHours();
                    hours = hours < 10 ? '0'+hours:hours;
                    var minutes = d.getMinutes();
                    minutes = minutes < 10 ? '0'+minutes:minutes;
                    //Текст
                    var text = hours+':'+minutes;
                    var textWidth = this.ctx.measureText(text).width / 2;
                    
                    this.ctx.save();
                        this.ctx.fillStyle = "#999";
                        this.ctx.font = "normal 9pt Arial";
                        this.ctx.fillText(text, this.x_margin+x - textWidth, 10);
                    this.ctx.restore();

                    start += 3600;
                }
            },
            timeToX:function(time){                
                var x = (this.width/(this.interval-3600))*(time-3600);
                
                return x;
            },
            timeToX2:function(time){
                var x = (this.width/(this.interval-3600))*(time-3600);
                
                return x;
            }
        }