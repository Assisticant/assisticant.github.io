---
title: Documentation
layout: doc
order: 2
---
## Observable&lt;T&gt;

Assisticant tracks dependencies within your application. Observable<T> is used as a field whenever you want Assisticant to track changes.

Declare the Observable<T> as a private field. You can replace T with a simple type like “int” or “string”. Or you can replace it with an object type, like “Person”.

```csharp
public class Person
{
    private Observable<string> _firstName = new Observable<string>();
    private Observable<string> _lastName = new Observable<string>();
    private Observable<Person> _spouse = new Observable<Person>();
}
```

Always initialize the field to a new Observable<T>. Forgetting this step will lead to null reference exceptions.

Expose the properties as the raw type T. The getter can return the Observable<T>, and it will be automatically converted to the raw type. But the setter has to assign to the Value property of the field.

```csharp
public class Person
{
    private Observable<string> _firstName = new Observable<string>();
    private Observable<string> _lastName = new Observable<string>();
    private Observable<Person> _spouse = new Observable<Person>();

    public string FirstName
    {
        get => _firstName;
        set => _firstName.Value = value;
    }

    public string LastName
    {
        get => _lastName;
        set => _lastName.Value = value;
    }

    public Person Spouse
    {
        get => _spouse;
        set => _spouse.Value = value;
    }
}
```

If you need to initialize the value of the field, pass the initial value to the Observable<T> constructor. Use the "obs" snippet to insert an observable property.

## ObservableList&lt;T&gt;

Observable<T> is used for single values. To track dependencies on collections, use ObservableList<T>. Use this as a field whenever you want to track changes to a collection.

```csharp
public class Document
{
    private ObservableList<Person> _people = new ObservableList<Person>();
}
```

Expose the field as a read-only property of type IEnumerable<T>. Usually, you want your class to be in charge of what gets added to the list. IEnumerable<T> lets other classes enumerate the elements of the list, but not modify it.

```csharp
public IEnumerable<Person> People => _people;
```

ObservableList<T> supports all of the methods of List<T>. You can Add, Insert, Remove, etc. just as you are used to.

```csharp
public Person NewPerson()
{
    Person person = new Person();
    _people.Add(person);
    return person;
}

public void DeletePerson(Person person)
{
    _people.Remove(person);
}
```

Any dependent properties that reference the list, even through the IEnumerable<T> interface, will take a dependency upon its contents. They will be updated when something is added to or removed from the list. Use the "obslist" snippet to insert an observable list property.

## View Models

View models are simple classes that hold references to models. They expose properties for the purpose of data binding. These properties are implemented as pass-through methods, getting and setting data from the models. Assisticant view models do not inherit from a base class or implement an interface.

```csharp
public class ItemViewModel
{
    private readonly Item _item;

    public ItemViewModel(Item Item)
    {
        _item = Item;
    }

    public string Name
    {
        get => _item.Name;
        set => _item.Name = value;
    }
}
```

The pass-through methods don’t have to be direct one-to-one accessors. In fact, they rarely are. It is far more common to alter the values on the way in and out. Here are some common types of alterations:

- Return a default value if it hasn’t been set in the model.
- Combine two or more model properties to display an aggregate.
- Project child model objects into child view models.

That last one is very important. View models don’t return models. They return other view models. You never want your view to data bind directly against a model object. It should always have a view model in between.

```csharp
public class MainViewModel
{
    private readonly Document _document;
    private readonly Selection _selection;

    public MainViewModel(Document document, Selection selection)
    {
        _document = document;
        _selection = selection;
    }

    public IEnumerable<ItemHeader> Items =>
        from item in _document.Items
        select new ItemHeader(item);
}
```

In addition to the top-level view models, you will often have headers. These are small view models created for the purpose of populating a list. The properties of a header are usually read-only, so you don’t create setters for them.

```csharp
public class ItemHeader
{
    private readonly Item _item;

    public ItemHeader(Item Item)
    {
        _item = Item;
    }

    public Item Item => _item;

    public string Name => _item.Name ?? "<New Item>";

    public override bool Equals(object obj)
    {
        if (obj == this)
            return true;
        ItemHeader that = obj as ItemHeader;
        if (that == null)
            return false;
        return Object.Equals(this._item, that._item);
    }

    public override int GetHashCode()
    {
        return _item.GetHashCode();
    }
}
```

A header always has to implement Equals and GetHashCode. These methods should compare two headers to see if they represent the same object. This allows Assisticant to preserve the selection and scroll position of a list even as the items in the list are changing. It also assists with binding the SelectedItem property. The SelectedItem should be equal to one element in the ItemsSource.

## ViewModelLocatorBase

The ViewModelLocator class has a property for each view model. Since it creates the view models, it also needs references to the model so it can call the constructors. These references are likely to include a selection model – an object responsible for keeping track of which item the user has selected. This comes in handy when the user can select something from the main view model, and then navigate to the child view. The selected item is passed into the constructor of the child view model.

```csharp
public class ViewModelLocator : ViewModelLocatorBase
{
    private Document _document;
    private Selection _selection;

    public ViewModelLocator()
    {
        if (DesignMode)
            _document = LoadDesignModeDocument();
        else
            _document = LoadDocument();
        _selection = new Selection();
    }

    public object Main => ViewModel(() =>
        new MainViewModel(_document, _selection));

    public object Child => ViewModel(() =>
        _selection.SelectedItem == null
            ? null
            : new ChildViewModel(_selection.SelectedItem));

    private Document LoadDocument()
    {
        // TODO: Load your document here.
        Document document = new Document();
        return document;
    }

    private Document LoadDesignModeDocument()
    {
        // TODO: Load your design mode data here.
        Document document = new Document();
        return document;
    }
}
```

The ViewModelLocatorBase class in Assisticant provides the ViewModel method. This method takes a lambda expression that creates the view model. Assisticant will cache the view model, and make sure that the constructor is called again if the parameters change. For example, when the user selects a different item, Assisticant will construct a new child view model.

## App.xaml

The application adds an instance of the view model locator to the resource dictionary. It references the namespace, and gives the object a key. This lets views find the locator.

```xml
<Application
    x:Class="MyCoolApp.App"
    xmlns:vm="clr-namespace:MyCoolApp.ViewModels">

    <!--Application Resources-->
    <Application.Resources>
        <vm:ViewModelLocator x:Key="Locator"/>
    </Application.Resources>
</Application>
```

There will be other things in the resource dictionary, including perhaps merged dictionaries. Just put the view model locator right inside the Application.Resources element.

## Binding a View to a View Model

Each view sets its data context by binding to a property of the view model locator. It sets the binding source to the view model locator as a static resource.

```xml
<UserControl
    x:Class="MyCoolApp.MainView"
    DataContext="{Binding Main, Source={StaticResource Locator}}">

</UserControl>
```

With this pattern, the view model locator is a singleton. Each view accesses a property of that single object to get its view model. The base class provided by Assisticant makes sure that a new view model is created if any of its constructor parameters change. This lets you set state in one view, and then depend upon that state as you navigate to another view. It’s a natural and straight-forward way of structuring your XAML applications.
