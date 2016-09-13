<div class="container">
    <div class="cont"></div>
    <div class="s-elements-wrapper incon">
        <div class="s-elements-grid valign-top xs-wrap" style="margin-left: 0px; margin-right: 0px;">
            
            <div class="s-elements-grid__cell" style="width: 25%; padding-left: 0px;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node527">
                                <style>.node527 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 15px;">
                                        <div class="cont">
                                            <div class="node widget widget-paragraph node576">
                                                <style>.node576 a { color: rgb(25,178,230); }</style>
                                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                    <div class="wrapper2" style="padding: 5px;">
                                                        <div class="xs-force-center">
                                                            <p style="text-align: center;"><strong>ЛОГИН</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="s-elements-grid__cell" style="width: 25%;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node528">
                                <style>.node528 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 15px;">
                                        <div class="cont">
                                            <div class="node widget widget-paragraph node579">
                                                <style>.node579 a { color: rgb(25,178,230); }</style>
                                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                    <div class="wrapper2" style="padding: 5px;">
                                                        <div class="xs-force-center">
                                                            <p style="text-align: center;"><strong>НАЧАЛЬНЫЙ ДЕПОЗИТ</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="s-elements-grid__cell" style="width: 25%;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node529">
                                <style>.node529 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 14px;">
                                        <div class="cont">
                                            <div class="node widget widget-paragraph node582">
                                                <style>.node582 a { color: rgb(25,178,230); }</style>
                                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                    <div class="wrapper2" style="padding: 5px;">
                                                        <div class="xs-force-center">
                                                            <p style="text-align: center;"><strong>БАЛАНС</strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="s-elements-grid__cell" style="width: 25%; padding-right: 0px;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node530">
                                <style>.node530 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 15px;">
                                        <div class="cont">
                                            <div class="node widget widget-paragraph node585">
                                                <style>.node585 a { color: rgb(25,178,230); }</style>
                                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                    <div class="wrapper2" style="padding: 5px;">
                                                        <div class="xs-force-center">
                                                            <p style="text-align: center;"><strong>ПРИБЫЛЬ <span style="font-size: 16px; font-family: georgia, palatino;">за месяц</span></strong></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                $cnt = ceil(count($this->profit)/3);
                $j = 1;
            ?>
            
            <?php for($i=1; $i <= $cnt ; $i++){ ?>
                <?php $position = ($j*3) - 3;?>
                <div class="s-elements-grid__cell" style="width: 25%; padding-left: 0px;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node527">
                                <style>.node527 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 15px;">
                                        <div class="cont">                            
                                            <?php for($k = $position; $k < $position+3; $k++){ ?>
                                            <?php if(!$this->profit[$k]) break;?>
                                                <div class="node widget widget-paragraph node577">
                                                     <style>.node577 a { color: rgb(25,178,230); }</style>
                                                     <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                         <div class="wrapper2" style="padding: 19px 5px;">
                                                             <div class="xs-force-center">
                                                                 <p style="line-height: 1.25;"><strong><?=$this->profit[$k]->login?></strong></p>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="s-elements-grid__cell" style="width: 25%;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node528">
                                <style>.node528 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 15px;">
                                        <div class="cont">
                                            <?php for($k = $position; $k < $position+3; $k++){ ?>
                                            <?php if(!$this->profit[$k]) break;?>
                                                <div class="node widget widget-paragraph node580">
                                                    <style>.node580 a { color: rgb(25,178,230); }</style>
                                                    <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                        <div class="wrapper2" style="padding: 5px;">
                                                            <div class="xs-force-center">
                                                                <p style="line-height: 1.25; text-align: center;"><span style="font-size: 36px;"><strong><?=$this->profit[$k]->deposit/100?> $</strong></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="s-elements-grid__cell" style="width: 25%;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node529">
                                <style>.node529 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 14px;">
                                        <div class="cont">
                                           <?php for($k = $position; $k < $position+3; $k++){ ?>
                                            <?php if(!$this->profit[$k]) break;?>
                                                <div class="node widget widget-paragraph node580">
                                                    <style>.node580 a { color: rgb(25,178,230); }</style>
                                                    <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                        <div class="wrapper2" style="padding: 5px;">
                                                            <div class="xs-force-center">
                                                                <p style="line-height: 1.25; text-align: center;"><span style="font-size: 36px;"><strong><?=$this->profit[$k]->balance/100?> $</strong></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><div class="s-elements-grid__cell" style="width: 25%; padding-right: 0px;">
                    <div class="s-elements-grid__cellwrapper" style="padding: 0px;">
                        <div class="cont">
                            <div class="node widget widget-element node530">
                                <style>.node530 a { color: rgb(25,178,230); }</style>
                                <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px; border: 1px solid rgb(230, 230, 230); box-shadow: rgba(179, 179, 179, 0.741176) 0px 8px 23px -9px; background-color: rgb(255, 255, 255);">
                                    <div class="wrapper2" style="padding: 5px 15px;">
                                        <div class="cont">
                                            <?php for($k = $position; $k < $position+3; $k++){ ?>
                                            <?php if(!$this->profit[$k]) break;?>
                                                <div class="node widget widget-paragraph node580">
                                                    <style>.node580 a { color: rgb(25,178,230); }</style>
                                                    <div class="wrapper1" style="color: rgb(13, 13, 13); border-radius: 0px;">
                                                        <div class="wrapper2" style="padding: 5px;">
                                                            <div class="xs-force-center">
                                                                <p style="line-height: 1.25; text-align: center;"><span style="font-size: 36px;"><strong><?=$this->profit[$k]->profit/100?> $</strong></span></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $j++ ?>
            <?php } ?>
        </div>
    </div>
    <div class="cont"></div>
</div>