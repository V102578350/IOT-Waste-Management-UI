<?php
require_once('assets/php/mysql.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Management UI</title>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="apple-touch-icon" sizes="76x76" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta property="og:title" content="Waste Management UI" />
    <meta property="og:description" content="Track waste management activities with ease using our intuitive and efficient waste management tracking UI. Monitor bin status, volume, and location in real-time for effective waste management." />
    <meta property="og:url" content="https://waste-management-ui.000webhostapp.com/" />
    <meta property="og:image" content="/share.jpg" />
    <meta name="theme-color" content="#ffffff">
</head>

<body>
    <header class="header">
        <div class="header-content">
            <img src="assets/images/icons/ico-trash.svg" alt="Trash Icon">
            <h1>Waste Management UI</h1>
        </div>
    </header>

    <div class="container">
        <div class="shell shell--fixed">
            <div class="section-bins">
                <h2>Your Bins</h2>
                <div class="bins">
                    <div class="bin-item template">
                        <div class="bin-header">
                            <h4 class="bin-title">
                                Smart Bin ID# 1
                            </h4>
                            <div class="bin-status">
                                <span></span>
                                <p>Offline</p>
                            </div>
                        </div>
                        <div class="bin-info">
                            <ul>
                                <li>
                                    <span>Location:</span>
                                    <div>
                                        <span></span>
                                        <img class="js-edit-location" src="assets/images/icons/ico-edit.svg" alt="Edit Icon">
                                    </div>
                                </li>
                                <li>
                                    <span>Volume (L):</span>
                                    <div>
                                        <span></span>
                                        <img class="js-edit-volume" src="assets/images/icons/ico-edit.svg" alt="Edit Icon">
                                    </div>
                                </li>
                                <li>
                                    <span>Status:</span>
                                    <span></span>
                                </li>
                                <li>
                                    <span>Last Update:</span>
                                    <span></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="bin-item skeleton">
                        <div class="bin-header">
                            <h4 class="bin-title skeleton"></h4>
                            <div class="bin-status">
                                <span class="skeleton"></span>
                                <p class="skeleton"></p>
                            </div>
                        </div>
                        <div class="bin-info">
                            <ul>
                                <li>
                                    <span>Location:</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Volume (L):</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Status:</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Last Update:</span>
                                    <span class="skeleton"></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bin-item skeleton">
                        <div class="bin-header">
                            <h4 class="bin-title skeleton"></h4>
                            <div class="bin-status">
                                <span class="skeleton"></span>
                                <p class="skeleton"></p>
                            </div>
                        </div>
                        <div class="bin-info">
                            <ul>
                                <li>
                                    <span>Location:</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Volume (L):</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Status:</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Last Update:</span>
                                    <span class="skeleton"></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bin-item skeleton">
                        <div class="bin-header">
                            <h4 class="bin-title skeleton"></h4>
                            <div class="bin-status">
                                <span class="skeleton"></span>
                                <p class="skeleton"></p>
                            </div>
                        </div>
                        <div class="bin-info">
                            <ul>
                                <li>
                                    <span>Location:</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Volume (L):</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Status:</span>
                                    <span class="skeleton"></span>
                                </li>
                                <li>
                                    <span>Last Update:</span>
                                    <span class="skeleton"></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>

            <div class="section-bin-logs">
                <h2>Your Logs</h2>

                <canvas class="chart"></canvas>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@2.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
<script src="assets/scripts/main.js"></script>

</html>