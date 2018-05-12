---
title: Collections
layout: doc
order: 3
---

## Linq

Use [ObservableList&lt;T&gt;](documentation.html#observablelistt) within a document to represent a collection. When exposing a collection through the view model, simply represent it as an `IEnumerable<T>`.

```csharp
public class Document
{
    private ObservableList<Person> _people = new ObservableList<Person>();

    public IEnumerable<Person> People => _people;
}

public class MainViewModel
{
    private readonly Document _document;

    public MainViewModel(Document document)
    {
        _document = document;
    }

    public IEnumerable<Person> People => _document.People;
}
```

Use Linq to map the source collection to a target view model. **This is Linq to Objects. You cannot bind to a persistent store with this technique.** Be sure to implement `Equals` and `GetHashCode` in the target view model.

```csharp
public class MainViewModel
{
    // ...

    public IEnumerable<PersonHeader> People =>
        from person in _document.People
        select new PersonHeader(person);
}
```

Or to sort.

```csharp
public class MainViewModel
{
    // ...

    public IEnumerable<PersonHeader> People =>
        from person in _document.People
        orderby person.LastName, person.FirstName
        select new PersonHeader(person);
}
```

Or to filter.

```csharp
public class MainViewModel
{
    // ...

    private Observable<string> _searchTerm = new Observable<string>("");

    public string SearchTerm
    {
        get => _searchTerm;
        set => _searchTerm.Value = value;
    }

    public IEnumerable<PersonHeader> People =>
        from person in _document.People
        where person.LastName.StartsWith(SearchTerm)
        select new PersonHeader(person);
}
```

The resulting collection will update when the sort or filter properties change, including the search term.

## BindingList&lt;T&gt;

You never have to manage an `ObservableCollection<T>` or `BindingList<T>` again. When Assisticant sees the above properties in your view model, it will generate an `ObservableCollection<T>` for you. As the source collection changes, it will keep it up to date.

If you add a method to your view model with the signature `PersonHeader NewItemInPeople()`, then Assisticant will generate a `BindingList<T>` for the `People` property. It will be managed just like `ObservableCollection<T>`, but will also respond to the view calling `AddNew()`. This is useful for grid controls, which allow the user to add a new row by typing into the blank row at the bottom of the grid.

```csharp
public class Document
{
    private ObservableList<Person> _people = new ObservableList<Person>();

    public IEnumerable<Person> People => _people;

    public Person NewPerson()
    {
        var person = new Person();
        _people.Add(person);
        return person;
    }
}

public class MainViewModel
{
    private readonly Document _document;

    public MainViewModel(Document document)
    {
        _document = document;
    }
    
    public IEnumerable<PersonsHeader> People =>
        from person in _document.People
        select new PersonHeader(person);

    public PersonHeader NewItemInPeople()
    {
        return new PersonHeader(_document.NewPerson());
    }
}
```

If you've used the `NewItemIn` convention to generate a `BindingList<T>`, then you can also use the `DeleteItemFrom` convention to support removal from the view. When a grid control deletes a row, Assisticant will call `DeleteItemFromPeople(PersonHeader)`.

```csharp
public class Document
{
    // ...

    public void DeletePerson(Person person)
    {
        _people.Remove(person);
    }
}

public class MainViewModel
{
    // ...

    public void DeleteItemFromPeople(PersonHeader personHeader)
    {
        _document.DeletePerson(personHeader.Person);
    }
}
```

Using this pattern, you never have to manage an `ObservableCollection<T>` or `BindingList<T>` again. But if you _do_ expose an `ObservableCollection<T>` or `BindingList<T>` from your view model, then Assisticant will assume that you _want_ to manage it yourself. Furthermore, it will not wrap any of the items within your observable collection or binding list. This is one way to break out of the wrapper. (The other is to implement `INotifyPropertyChanged` manually, which affects the entire view model.)

## Equals and GetHashCode

For Assisticant to manage your collections, the child view models in the collections need to implement Equals and GetHashCode. These should delegate their implementation to the model objects that they represent.

```csharp
public class PersonHeader
{
    internal Person Person { get; }

    public PersonHeader(Person person)
    {
        Person = person;
    }

    public string Name => $"{Person.LastName}, {Person.FirstName}";

    public override bool Equals(object obj)
    {
        if (obj == this)
            return true;
        var that = obj as PersonHeader;
        if (that == null)
            return false;

        return object.Equals(this.Person, that.Person);
    }

    public override int GetHashCode() => Person.GetHashCode();
}
```

These methods are used for object recycling. When a collection changes, Asssisticant will re-run the Linq query. Remember, this is Linq to Objects, not Linq to SQL or Entity Framework, so it's fast. Once it has the new collection, it will look for existing objects in the `ObservableCollection<T>` or `BindingList<T>`. It will reuse those existing objects instead of the new ones.

The benefit of object recycling is that the user interface components bound to those existing elements are not updated. This improves the performance of the UI, but more importantly, preserves the user's state. If they have scrolled down the list, then inserting a new element will not affect their scroll position. If they have selected an item in the list, then that item will remain selected after the update. And if you are using entrance or exit animations to visualize changes to a list, those will fire only on the inserted and deleted items.

Object recycling provides benefits similar to the Virtual DOM in frameworks like React. If you find that the user interface does not behave correctly, then please double-check that you have implemented `Equals` and `GetHashCode`.