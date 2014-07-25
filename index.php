<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Assisticant</title>
    <meta name="description" content="Thoughtful, intelligent data binding">
    <meta name="author" content="Michael L Perry">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/site.css" rel="stylesheet">
    <link href="flaticons/flaticon.css" rel="stylesheet">
    <link rel="shortcut icon" href="favicon.png">
</head>
<body>
<header id="home">
    <?php include_once "template/header.php"; ?>
</header>
<!-- Jumbotron -->
<div id="main">
    <div class="container">
        <div class="row">
            <div class="jumbotron">
                <div class="col-sm-4 text-right hidden-xs hidden-sm">
                    <img src="images/Logo.png" class="img-responsive inline-block">
                </div>
                <div class="col-sm-6">
                    <div class="text-center">
                        <h1>Assisticant</h1>

                        <p class="lead"><i class="flaticon-light28"></i>Thoughtful, intelligent data binding</p>
                        <a class="btn btn-large btn-success" href="#setup"> <i class="flaticon-thunderbolt1"></i> Get
                            Started</a>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<div id="intro">
<div class="container">
<div id="clean" class="row">
    <div class="col-sm-12">
        <p class="well">
            Your typical MVVM framework requires you to raise property changed events. Assisticant is more thoughtful.
            She figures out when the UI needs to be updated. You just write your code. She intelligently follows
            your logic and raises property changed and collection changed events exactly when she should.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="box">
            <h3>Typical MVVM</h3>
<pre class="code"><span class="keyword">public class </span><span class="type">PersonViewModel</span> :
  <span class="type">ViewModelBase</span>
{
  <span class="keyword">private string</span> _first;
  <span class="keyword">private string</span> _last;

  <span class="keyword">public string </span>First
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_first; }
    <span class="keyword">set </span>
    {
      _first = <span class="keyword">value</span>;
      RaisePropertyChanged(() => First);
      RaisePropertyChanged(() => Full);
    }
  }

  <span class="keyword">public string </span>Last
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_last; }
    <span class="keyword">set </span>
    {
      _last = <span class="keyword">value</span>;
      RaisePropertyChanged(() => Last);
      RaisePropertyChanged(() => Full);
    }
  }

  <span class="keyword">public string </span>Full
  {
    <span class="keyword">get</span>
    {
      <span class="keyword">return </span>First + <span class="string">&quot; &quot;</span> + Last;
    }
  }
}</pre>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box">
            <h3>Assisticant</h3>
<pre class="code"><span class="keyword">public class </span><span class="type">PersonViewModel
</span>{
  <span class="keyword">private </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt; _first =
    <span class="keyword">new </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt;();
  <span class="keyword">private </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt; _last =
    <span class="keyword">new </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt;();

  <span class="keyword">public string </span>First
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_first; }
    <span class="keyword">set </span>{ _first.Value = <span class="keyword">value</span>; }
  }

  <span class="keyword">public string </span>Last
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_last; }
    <span class="keyword">set </span>{ _last.Value = <span class="keyword">value</span>; }
  }

  <span class="keyword">public string </span>Full
  {
    <span class="keyword">get</span>
    {
      <span class="keyword">return </span>First + <span class="string">&quot; &quot;</span> + Last;
    }
  }
}</pre>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="box">
            <h3>The Result</h3>
            <img src="PersonName.gif" class="img-responsive" alt="FullName property updates automatically.">
        </div>
    </div>
</div>
<hr>
<div id="cross" class="row">
    <div class="col-sm-12">
        <p class="well">Assisticant will even discover dependencies <strong>across object boundaries</strong>. You don't
            need to
            subscribe to events.</p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="box">
            <h3>Typical MVVM</h3>
<pre class="code"><span class="keyword">public class </span><span class="type">PersonModel </span>: <span class="type">ObservableBase
</span>{
  <span class="keyword">private string </span>_first;
  <span class="keyword">private string </span>_last;

  <span class="keyword">public string </span>First
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_first; }
    <span class="keyword">set
    </span>{
      _first = <span class="keyword">value</span>;
      RaisePropertyChanged(() =&gt; First);
    }
  }

  <span class="keyword">public string </span>Last
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_last; }
    <span class="keyword">set
    </span>{
      _last = <span class="keyword">value</span>;
      RaisePropertyChanged(() =&gt; Last);
    }
  }
}
</pre>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
            <h3>Assisticant</h3>
<pre class="code"><span class="keyword">public class </span><span class="type">PersonModel
</span>{
  <span class="keyword">private </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt; _first =
    <span class="keyword">new </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt;();
  <span class="keyword">private </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt; _last =
    <span class="keyword">new </span><span class="type">Observable</span>&lt;<span class="keyword">string</span>&gt;();

  <span class="keyword">public string </span>First
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_first; }
    <span class="keyword">set </span>{ _first.Value = <span class="keyword">value</span>; }
  }

  <span class="keyword">public string </span>Last
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_last; }
    <span class="keyword">set </span>{ _last.Value = <span class="keyword">value</span>; }
  }
}
</pre>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="box">
<pre class="code"><span class="keyword">public class </span><span class="type">PersonViewModel </span>: <span
        class="type">ViewModelBase
</span>{
  <span class="keyword">private readonly </span><span class="type">PersonModel </span>_person;

  <span class="keyword">public </span>PersonViewModel(<span class="type">PersonModel </span>person)
  {
    _person = person;
    _person.PropertyChanged += PersonPropertyChanged;
  }

  <span class="keyword">void </span>PersonPropertyChanged(
    <span class="keyword">object </span>sender, <span class="type">PropertyChangedEventArgs </span>e)
  {
    <span class="keyword">if </span>(e.PropertyName == <span class="string">"First"</span>)
    {
      RaisePropertyChanged(() =&gt; First);
      RaisePropertyChanged(() =&gt; Full);
    }
    <span class="keyword">else if </span>(e.PropertyName == <span class="string">"Last"</span>)
    {
      RaisePropertyChanged(() =&gt; Last);
      RaisePropertyChanged(() =&gt; Full);
    }
  }

  <span class="keyword">public string </span>First
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_person.First; }
    <span class="keyword">set </span>{ _person.First = <span class="keyword">value</span>; }
  }

  <span class="keyword">public string </span>Last
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_person.Last; }
    <span class="keyword">set </span>{ _person.Last = <span class="keyword">value</span>; }
  }

  <span class="keyword">public string </span>Full
  {
    <span class="keyword">get
    </span>{
      <span class="keyword">return </span>_person.First + <span class="string">&quot; &quot;</span> + _person.Last;
    }
  }
}
</pre>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
<pre class="code"><span class="keyword">public class </span><span class="type">PersonViewModel
</span>{
  <span class="keyword">private readonly </span><span class="type">PersonModel </span>_person;

  <span class="keyword">public </span>PersonViewModel(<span class="type">PersonModel </span>person)
  {
    _person = person;
  }

  <span class="keyword">public string </span>First
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_person.First; }
    <span class="keyword">set </span>{ _person.First = <span class="keyword">value</span>; }
  }

  <span class="keyword">public string </span>Last
  {
    <span class="keyword">get </span>{ <span class="keyword">return </span>_person.Last; }
    <span class="keyword">set </span>{ _person.Last = <span class="keyword">value</span>; }
  }

  <span class="keyword">public string </span>Full
  {
    <span class="keyword">get
    </span>{
      <span class="keyword">return </span>_person.First + <span class="string">&quot; &quot;</span> + _person.Last;
    }
  }
}
</pre>
        </div>
    </div>
</div>
<hr>
<div id="bus" class="row">
    <div class="col-sm-12">
        <p class="well">
            Because Assisticant can track dependencies across objects, you don&apos;t need to use a <strong>message
                bus</strong> to keep view models
            in sync with one another. Just move the shared state to an object that both view models depend upon.
        </p>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="box">
            <h3>Typical MVVM</h3>
<pre class="code"><span class="keyword">public</span> <span class="keyword">class</span> <span
        class="type">PersonSelectorViewModel</span> : <span class="type">ViewModelBase</span>
{
  <span class="keyword">private</span> <span class="keyword">readonly</span> <span class="type">Directory</span> _directory;
  <span class="keyword">private</span> <span class="keyword">readonly</span> <span class="type">List</span>&lt;<span
        class="type">PersonViewModel</span>&gt; _people;
  <span class="keyword">private</span> <span class="type">PersonViewModel</span> _selectedPerson = <span
        class="keyword">null</span>;

  <span class="keyword">public</span> PersonSelectorViewModel(
    <span class="type">Directory</span> directory)
  {
    _directory = directory;

    _people = _directory.GetPeople()
      .Select(person =&gt; <span class="keyword">new</span> <span class="type">PersonViewModel</span>
      {
        Id = person.Id,
        First = person.First,
        Last = person.Last
      })
      .ToList();
  }

  <span class="keyword">public</span> <span class="type">IEnumerable</span>&lt;<span class="type">PersonViewModel</span>&gt; People
  {
    <span class="keyword">get</span> { <span class="keyword">return</span> _people; }
  }

  <span class="keyword">public</span> <span class="type">PersonViewModel</span> SelectedPerson
  {
    <span class="keyword">get</span> { <span class="keyword">return</span> _selectedPerson; }
    <span class="keyword">set</span>
    {
      <span class="keyword">if</span> (_selectedPerson == value)
        <span class="keyword">return</span>;

      _selectedPerson = value;
      RaisePropertyChanged(() =&gt; <span class="keyword">this</span>.SelectedPerson);

      <span class="type">MessengerInstance</span>.Send(<span class="keyword">new</span> <span class="type">PersonSelected</span>
      {
        PersonId = value.Id
      });
    }
  }
}
</pre>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
            <h3>Assisticant</h3>
<pre class="code"><span class="keyword">public</span> <span class="keyword">class</span> <span
        class="type">PersonSelectorViewModel</span>
{
  <span class="keyword">private</span> <span class="keyword">readonly</span> <span class="type">Directory</span> _directory;
  <span class="keyword">private</span> <span class="keyword">readonly</span> <span class="type">List</span>&lt;<span
        class="type">PersonViewModel</span>&gt; _people;
  <span class="keyword">private</span> <span class="keyword">readonly</span> <span
        class="type">PersonSelectionModel</span> _personSelection;

  <span class="keyword">public</span> PersonSelectorViewModel(
    <span class="type">Directory</span> directory,
    <span class="type">PersonSelectionModel</span> personSelection)
  {
    _directory = directory;
    _personSelection = personSelection;

    _people = _directory.GetPeople()
      .Select(person =&gt; <span class="keyword">new</span> <span class="type">PersonViewModel</span>(
        _personSelection.SelectedPerson))
      .ToList();
  }

  <span class="keyword">public</span> <span class="type">IEnumerable</span>&lt;<span class="type">PersonViewModel</span>&gt; People
  {
    <span class="keyword">get</span> { <span class="keyword">return</span> _people; }
  }

  <span class="keyword">public</span> <span class="type">PersonViewModel</span> SelectedPerson
  {
    <span class="keyword">get</span>
    {
      <span class="keyword">return</span> _people.FirstOrDefault(p =&gt;
        p.Person == _personSelection.SelectedPerson);
    }
    <span class="keyword">set</span>
    {
      _personSelection.SelectedPerson = <span class="keyword">value</span> == <span class="keyword">null</span>
        ? <span class="keyword">null</span>
        : <span class="keyword">value</span>.Person;
    }
  }
}
</pre>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="box">
<pre class="code"><span class="keyword">public</span> <span class="keyword">class</span> <span
        class="type">PersonDetailViewModel</span> : <span class="type">ViewModelBase</span>
{
  <span class="keyword">private</span> <span class="type">Directory</span> _directory;
  <span class="keyword">private</span> <span class="keyword">int</span> _id;
  <span class="keyword">private</span> <span class="keyword">string</span> _first;
  <span class="keyword">private</span> <span class="keyword">string</span> _last;

  <span class="keyword">public</span> PersonDetailViewModel()
  {
    _directory = <span class="keyword">new</span> <span class="type">Directory</span>();
    <span class="type">MessengerInstance</span>.Register&lt;<span class="type">PersonSelected</span>&gt;(<span
        class="keyword">this</span>, message =&gt;
    {
      var person = _directory.LoadSession(message.PersonId);
      _id = message.PersonId;
      First = person.First;
      Last = person.Last;
    });
  }

  <span class="keyword">public</span> <span class="keyword">string</span> First
  {
    <span class="keyword">get</span> { <span class="keyword">return</span> _first; }
    <span class="keyword">set</span>
    {
      <span class="keyword">if</span> (<span class="keyword">value</span> == _first)
        <span class="keyword">return</span>;

      _first = <span class="keyword">value</span>;
      RaisePropertyChanged(() =&gt; <span class="keyword">this</span>.First);

      <span class="type">MessengerInstance</span>.Send(<span class="keyword">new</span> <span class="type">PersonNameChanged</span>
      {
        PersonId = _id,
        First = <span class="keyword">value</span>,
        Last = Last
      });
    }
  }

  <span class="keyword">public</span> <span class="keyword">string</span> Last
  {
    <span class="keyword">get</span> { <span class="keyword">return</span> _last; }
    <span class="keyword">set</span>
    {
      <span class="keyword">if</span> (<span class="keyword">value</span> == _last)
        <span class="keyword">return</span>;

      _last = <span class="keyword">value</span>;
      RaisePropertyChanged(() =&gt; <span class="keyword">this</span>.Last);

      <span class="type">MessengerInstance</span>.Send(<span class="keyword">new</span> <span class="type">PersonNameChanged</span>
      {
        PersonId = _id,
        First = First,
        Last = <span class="keyword">value</span>
      });
    }
  }
}
</pre>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
<pre class="code"><span class="keyword">public</span> <span class="keyword">class</span> <span
        class="type">PersonDetailViewModel</span>
{
  <span class="keyword">private</span> <span class="keyword">readonly</span> <span
        class="type">PersonSelectionModel</span> _personSelection;

  <span class="keyword">public</span> PersonDetailViewModel(
    <span class="type">PersonSelectionModel</span> personSelection)
  {
    _personSelection = personSelection;
  }

  <span class="keyword">public</span> <span class="keyword">string</span> First
  {
    <span class="keyword">get</span>
    {
      <span class="keyword">if</span> (_personSelection.SelectedPerson == <span class="keyword">null</span>)
        <span class="keyword">return</span> <span class="keyword">null</span>;

      <span class="keyword">return</span> _personSelection.SelectedPerson.First;
    }
    <span class="keyword">set</span>
    {
      <span class="keyword">if</span> (_personSelection.SelectedPerson == <span class="keyword">null</span>)
        <span class="keyword">return</span>;

      _personSelection.SelectedPerson.First = <span class="keyword">value</span>;
    }
  }

  <span class="keyword">public</span> <span class="keyword">string</span> Last
  {
    <span class="keyword">get</span>
    {
      <span class="keyword">if</span> (_personSelection.SelectedPerson == <span class="keyword">null</span>)
        <span class="keyword">return</span> <span class="keyword">null</span>;

      <span class="keyword">return</span> _personSelection.SelectedPerson.Last;
    }
    <span class="keyword">set</span>
    {
      <span class="keyword">if</span> (_personSelection.SelectedPerson == <span class="keyword">null</span>)
        <span class="keyword">return</span>;

      _personSelection.SelectedPerson.Last = <span class="keyword">value</span>;
    }
  }
}
</pre>
<pre class="code"><span class="keyword">public</span> <span class="keyword">class</span> <span
        class="type">PersonSelectionModel</span>
{
  <span class="keyword">private</span> <span class="type">Observable</span>&lt;<span class="type">PersonModel</span>&gt; _selectedPerson =
    <span class="keyword">new</span> <span class="type">Observable</span>&lt;<span class="type">PersonModel</span>&gt;();

  <span class="keyword">public</span> <span class="type">PersonModel</span> SelectedPerson
  {
    <span class="keyword">get</span> { <span class="keyword">return</span> _selectedPerson; }
    <span class="keyword">set</span> { _selectedPerson.Value = <span class="keyword">value</span>; }
  }
}
</pre>
        </div>
    </div>
</div>
</div>
</div>
<div id="setup">
    <div class="container">
        <h1>Setup</h1>

        <p>To get started, create a project for the XAML platform of your choice:</p>
        <ul>
            <li>WPF</li>
            <li>Windows Store</li>
            <li>Windows Phone</li>
            <li>Universal</li>
            <li>Silverlight</li>
        </ul>

        <p>Add a reference to the Assisticant.App NuGet package.</p>

        <div class="nuget-badge">
            <p><code>PM&gt; Install-Package Assisticant.App</code></p>
        </div>

        <p>Create portable class libraries for all of your shared code. Add the Assisticant NuGet package to these
            projects.</p>

        <div class="nuget-badge">
            <p><code>PM&gt; Install-Package Assisticant</code></p>
        </div>

        <p>To use the Visual Studio snippets, install the Assisticant.Snippets package. You only need to do this once
            per development machine.</p>

        <div class="nuget-badge">
            <p><code>PM&gt; Install-Package Assisticant.Snippets</code></p>
        </div>
    </div>
</div>
<footer>
    <?php include_once "template/footer.php"; ?>
</footer>
<!-- /container -->
<script>
    jQuery(function () {
        if ($(window).width() >= 980) {
            jQuery('#main').css({
                'height': ((jQuery(window).height())) + 'px'
            });
            jQuery("#subnav").css({
                'top': (jQuery(window).height()) - 50 + 'px'
            });
            jQuery("#subnav").attr("data-offset-top", (jQuery(window).height()) - 100);
            jQuery(window).resize(function () {
                jQuery('#main').css({
                    'height': ((jQuery(window).height())) + 'px'
                });
                jQuery("#subnav").css({
                    'top': (jQuery(window).height()) - 50 + 'px'
                });
                jQuery("#subnav").attr("data-offset-top", (jQuery(window).height()) - 100);
            });
        } else {

            var mobileMenu = $("#LargeSubMenu").html();
            console.log(mobileMenu);
            $("#mobileSubMenu").html(mobileMenu);
        }
    });
    $(function () {
        $('a[href*=#]:not([href=#])').click(function () {
            $(".active").removeClass("active");
            $(this).addClass("active");
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top - 90
                    }, 1000);
                    return false;
                }
            }
        });
    });
</script>
</body>
</html>