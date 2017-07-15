---
title: Validation
layout: doc
order: 3
---
Assisticant supports validation using `INotifyDataErrorInfo` in WPF. Validation on other platforms is not currently supported.

## IValidation

To enable validation on your view model, implement the `IValidation` interface. This interface has one property: `Rules`. Use the `Validator` class to produce validation rules. Add properties using the `For` method, providing a lambda selecting the property. Finish it off with a call to `Build`.

```csharp
public class PersonViewModel : IValidation
{
    public string Name { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Name)
            .NotNullOrWhitespace()
        .Build();
}
```

Provide validation rules for multiple properties with additional calls to `For`.

```csharp
public class PersonViewModel : IValidation
{
    public string FirstName { get; set; }
    public string LastName { get; set; }

    public IValidationRules Rules => Validator
        .For(() => FirstName)
            .NotNullOrWhitespace()
        .For(() => LastName)
            .NotNullOrWhitespace()
        .Build();
}
```

To display validation errors in XAML, set the `ValidatesOnNotifyDataErrors` binding property.

```xml
<TextBox Binding="Name, ValidatesOnNotifyDataErrors=True">
```

## String validation

### NotNullOrEmpty

The input must contain at least one character.

```csharp
public class PersonViewModel : IValidation
{
    public string Name { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Name)
            .NotNullOrEmpty()
        .Build();
}
```

### NotNullOrWhitespace

The input must contain at least one non-whitespace character.

```csharp
public class PersonViewModel : IValidation
{
    public string Name { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Name)
            .NotNullOrWhitespace()
        .Build();
}
```

### MaxLength

The input may contain no more than the specified number of characters. Nulls are allowed.

```csharp
public class PersonViewModel : IValidation
{
    public string Name { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Name)
            .MaxLength(50)
        .Build();
}
```

### Matches

The input must match the specified regular expression. If the whole string needs to match, then use "^" and "$". Otherwise, only part of the string must match. Nulls are allowed.

```csharp
public class PersonViewModel : IValidation
{
    public string PhoneNumber { get; set; }

    public IValidationRules Rules => Validator
        .For(() => PhoneNumber)
            .Matches(@"^[0-9\-\(\)]*$")
        .Build();
}
```

To disallow nulls, combine the rule with `NotNull`

```csharp
public class PersonViewModel : IValidation
{
    public string PhoneNumber { get; set; }

    public IValidationRules Rules => Validator
        .For(() => PhoneNumber)
            .NotNull()
            .Matches(@"^[0-9\-\(\)]*$")
        .Build();
}
```


## Numeric validation

The following rules can be applied to any numeric properties, including `int`, `double`, `decimal`, etc. They can also be used for comparing strings lexicographically.

### GreaterThan

The input must be greater than the supplied value.

```csharp
public class PersonViewModel : IValidation
{
    public int Age { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Age)
            .GreaterThan(0)
        .Build();
}
```

To specify a range, combine two rules.

```csharp
public class PersonViewModel : IValidation
{
    public int Age { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Age)
            .GreaterThan(0)
            .LessThan(150)
        .Build();
}
```

### GreaterThanOrEqualTo

The input must be greater than or equal to the supplied value.

```csharp
public class PersonViewModel : IValidation
{
    public decimal Price { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Price)
            .GreaterThanOrEqualTo(10.0m)
        .Build();
}
```

### LessThan

The input must be less than the supplied value.

```csharp
public class PersonViewModel : IValidation
{
    public double Speed { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Speed)
            .LessThan(299792458.0)
        .Build();
}
```

### LessThanOrEqualTo

The input must be less than or equal to the supplied value.

```csharp
public class PersonViewModel : IValidation
{
    public byte Code { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Code)
            .LessThanOrEqualTo((byte)0x7f)
        .Build();
}
```

## Custom messages

The rules listed above will produce a validation message based on the property name and provided value. You can provide a custom message if the property name is not human readable, if the provided message does not give enough information, or if you want to localize the message. Call the `WithMessage` method.

```csharp
public class PersonViewModel : IValidation
{
    public byte Code { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Code)
            .LessThanOrEqualTo((byte)0x7f)
            .WithMessage(() => "The high bit of the code must be zero.")
        .Build();
}
```

## Custom validation

The rules listed above validate against constant values. To validate against other values, or to provide your own validation logic, use the `Where` method. Provide a lambda that takes the property value and returns `true` if it is valid. You must provide a validation message.

```csharp
public class PersonViewModel : IValidation
{
    public DateTime Birth { get; set; }
    public DateTime? Death { get; set; }

    public IValidationRules Rules => Validator
        .For(() => Birth)
            .Where(v => v <= DateTime.Today)
            .WithMessage(() => "Birth date not be in the future.")
        .For(() => Death)
            .Where(v => v == null || v > Birth)
            .WithMessage(() => "Death date must be after birth date.")
        .Build();
}
```

