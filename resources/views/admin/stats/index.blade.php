@extends('layouts.admin')
@section('content')
    <div class="title-page">
        Dashboard
    </div>
    <div class="col-md-12">

        <!-- tabs left -->
        <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#a" data-toggle="tab">Today</a></li>
                <li><a href="#b" data-toggle="tab">All</a></li>
                <li><a href="#c" data-toggle="tab">Range</a></li>
                <li><a href="#d" data-toggle="tab">Storage</a></li>
            </ul>
            <div class="tab-content clearfix">
                <div class="tab-pane active fade in col-md-11" id="a">

                    <div class="box-shadow-default stats-box-wrapper">
                        <h4 class="position-relative"> BEATS SOLD TODAY </h4>
                        <div class="stats-table-wrapper">
                            <table id="today_beats" class="table-stats-wrap table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Count</th>
                                    <th>Title</th>
                                    <th>Categories</th>
                                    <th>Price</th>
                                    <th>Types</th>
                                    <th>BPM</th>
                                    <th>Created at</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade col-md-11" id="b">

                    <div class="box-shadow-default stats-box-wrapper">
                        <h4> TOTAL NUMBER OF BEATS SOLD </h4>

                        <div class="stats-table-wrapper">
                            <table id="all_beats" class="table-stats-wrap table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Count</th>
                                    <th>Title</th>
                                    <th>Categories</th>
                                    <th>Price</th>
                                    <th>Types</th>
                                    <th>BPM</th>
                                    <th>Created at</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade col-md-11" id="c">

                    <div class="box-shadow-default stats-box-wrapper" id="date-range-wrapper">
                        <h4> DATE RANGE STATISTICS </h4>
                        <input type="text" name="daterange"/>
                        <div class="stats-table-wrapper">
                            <table id="date_range_beats" class="table-stats-wrap table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Count</th>
                                    <th>Title</th>
                                    <th>Categories</th>
                                    <th>Price</th>
                                    <th>Types</th>
                                    <th>BPM</th>
                                    <th>Created at</th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade col-md-11" id="d">

                    <div class="box-shadow-default stats-box-wrapper clearfix" id="date-range-wrapper">
                        <h4> STORAGE GRAPH </h4>

                        <div class="c100 p{{$storage_percentage}} big">

                            <span>{{$storage_stat}}/2gb</span>

                            <div class="slice">

                                <div class="bar"></div>
                                <div class="fill"></div>

                            </div>

                        </div>


                    </div>

                    </div>

                </div>
            </div>
        </div>
        <!-- /tabs -->
@endsection