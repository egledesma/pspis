<div class="page">

    <div class="page-header page-header-bordered">

        <h1 class="page-title">Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="../index.html">Dashboard</a></li>
           <!-- <li><a href="javascript:void(0)">Layouts</a></li> -->
        </ol>
    </div>

    <div class="page-content padding-30 container-fluid">
        <div class="row" data-plugin="matchHeight" data-by-row="true">
            <div class="col-xlg-6 col-md-12">
                <!-- Panel Predictions -->
                <div class="widget widget-shadow widget-responsive" id="widgetLineareaColor">
                    <div class="widget-content widget-radius bg-white">
                        <div class="padding-top-30 padding-30" style="height:calc(100% - 250px);">
                            <div class="row">
                                <div class="col-xs-7">
                                    <p class="font-size-20 blue-grey-700">Eneergy Predictions</p>
                                    <p>Quisque volutpat condimentum velit. Class aptent taciti</p>
                                    <div class="counter counter-md text-left">
                                        <div class="counter-number-group">
                                            <span class="counter-icon red-600"><i class="icon wb-triangle-up" aria-hidden="true"></i></span>
                                            <span class="counter-number red-600">2,250</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="pull-right clearfix">
                                        <ul class="list-unstyled">
                                            <li class="margin-bottom-5 text-truncate">
                                                <i class="icon wb-medium-point green-600 margin-right-5" aria-hidden="true"></i>                          Diretary intake
                                            </li>
                                            <li class="margin-bottom-5 text-truncate">
                                                <i class="icon wb-medium-point orange-600 margin-right-5" aria-hidden="true"></i>                          Motion
                                            </li>
                                            <li class="margin-bottom-5 text-truncate">
                                                <i class="icon wb-medium-point red-600 margin-right-5" aria-hidden="true"></i>                          Other
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ct-chart height-250"></div>
                    </div>
                </div>
                <!-- End Panel Predictions -->
            </div>

            <div class="col-xlg-3 col-md-6">
                <!-- Panel Snowing -->
                <div class="widget widget-shadow" style="overflow:hidden;">
                    <div class="widget-content widget-radius text-center bg-white">
                        <div class="padding-30 blue-grey-500 height-300">
                            <canvas id="widgetSnow" height="145" width="100"></canvas>
                            <div class="font-size-40">-4°
                                <span class="font-size-30">C</span>
                            </div>
                            <div class="blue-grey-400">SNOWING</div>
                        </div>
                        <div class="bg-blue-600 padding-horizontal-30 padding-vertical-25" style="height:calc(100% - 300px);">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="white">
                                        <i class="wb-triangle-down font-size-20 margin-right-5"></i>
                      <span class="font-size-30">
                        -8°
                        <span class="font-size-24">C</span>
                      </span>
                                    </div>
                                    <div class="blue-grey-100">LOW</div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="white">
                                        <i class="wb-triangle-up font-size-20 margin-right-5"></i>
                      <span class="font-size-30">
                        1°
                        <span class="font-size-24">C</span>
                      </span>
                                    </div>
                                    <div class="blue-grey-100">HIGH</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Panel Snowing -->
            </div>

            <div class="col-xlg-3 col-md-6">
                <!-- Panel Market Dow -->
                <div class="widget widget-shadow" id="widgetStackedBar">
                    <div class="widget-content widget-radius bg-white">
                        <div class="padding-30 height-150">
                            <p>MARKET DOW</p>
                            <div class="red-600">
                                <i class="wb-triangle-up font-size-20 margin-right-5"></i>
                                <span class="font-size-30">26,580.62</span>
                            </div>
                        </div>
                        <div class="counters padding-bottom-20 padding-horizontal-30" style="height:calc(100% - 350px);">
                            <div class="row no-space">
                                <div class="col-xs-4">
                                    <div class="counter counter-sm">
                                        <div class="counter-label text-uppercase">APPL</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related green-600">+</span>
                                            <span class="counter-number green-600">82.24</span>
                                            <span class="counter-number-related green-600">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="counter counter-sm">
                                        <div class="counter-label text-uppercase">FB</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related red-600">-</span>
                                            <span class="counter-number red-600">12.06</span>
                                            <span class="counter-number-related red-600">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="counter counter-sm">
                                        <div class="counter-label text-uppercase">GOOG</div>
                                        <div class="counter-number-group text-truncate">
                                            <span class="counter-number-related green-600">+</span>
                                            <span class="counter-number green-600">24.86</span>
                                            <span class="counter-number-related green-600">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ct-chart height-200"></div>
                    </div>
                </div>
                <!-- End Panel Market Dow -->

            </div>





        </div>
    </div>
</div>