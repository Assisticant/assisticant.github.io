<nav id="navaff" class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display fade in" data-spy="affix" data-offset-top="0" -->
        <div class="navbar-header col-md-2">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php#home">Assisticant</a>
        </div>

        <div class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav col-md-9">
                <li class="active"><a href="index.php#home">Home</a></li>
                <li><a href="documentation.php">Documentation</a></li>
                <li><a href="#">Examples</a></li>
                <li><a href="#">Patterns</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <ul class="nav navbar-nav visible-xs visible-sm" id="mobileSubMenu">
            </ul>
        </div>
    </div>
</nav>
<div id="subnav" class="fade in hidden-sm hidden-xs" data-spy="affix" data-offset-top="0">
    <div class="navbar navbar-inverse navbar-static-top">
        <div class="container text-center">
            <ul class="nav navbar-nav inline-block" id="LargeSubMenu">
                <li><a href="index.php#setup">Setup</a></li>
                <li><a href="#clean">No RaisePropertyChanged</a></li>
                <li><a href="#cross">Cross object boundaries</a></li>
                <li><a href="#bus">No message bus</a></li>
            </ul>
        </div>
    </div>
</div>