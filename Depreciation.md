## Based on Categories ##
The method of depreciation should be determined by the category it is in. So once we're ready to support depreciation, we should have a column in the [Categories](Categories.md) table that stores the method of depreciation required for that [Category](Categories.md).


## Methods ##
Initially, we expect to need to support two different methods of depreciation. A third option (see below) may be needed down the road, but is not necessary for our current needs.

First, we need to support a _Flat Rate_ depreciation method. This method consists of a flat dollar amount (defined per-[Asset](Assets.md)) being depreciated each year. This amount would have to be entered by a [Super Admin](Users#Super_Admin.md). This method would be represented by a single _Flat Rate_ option on the Depreciation Method drop-down for each Category, despite each [Asset](Assets.md) having a unique Flat Rate depreciation amount.

Second, we need to support a _MACRS_ (pronounced _makers_) method. This method would be represented by a series of year values (3, 5, 7, 10, 15, and 20) that each have a specific percentage of depreciation to occur each year (outlined [here](http://en.wikipedia.org/wiki/MACRS)). An accounting department will need ot map the different [Categories](Categories.md) to one of the above year values according to the appropriate IRS guidelines. A variance of this might be necessary wherein items in service during the last quarter of the year have a slightly different set of rules for each of the year values.

Third, in case we ever have need to support it, a _Straight Line_ method exists out there as well. It basically consists of a set of year values that are evenly broken up (rather than the varying MACRS percentages) over the depreciation lifetime of the [Asset](Assets.md). While this is at face value simpler to calculate, it requires monthly proration based on the in-service date, which adds a layer of complexity and might be unnecessary given the common use of the MACRS method.

In addition to the above, the Depreciation Method drop-down should include an _Inherit_ option, which would be the default setting and would indicate that the Depreciation Method should be inherited from the Category's parent. If the [Category](Categories.md) is a top-level Category, this option should be disabled.


## EoY Report ##
The _win_ for this facet of the application is to be able to produce an Excel (CSV?) list of all [Assets](Assets.md) with the following information, based on a given year (current year by default, but others available):
  1. Name
  1. Purchase Date
  1. Disposal Date (if applicable)
  1. Cost
  1. Depreciation Method
  1. Year Expenses (Depreciation to occur during the given year)
  1. Accumulated Depreciation

On the last two items, only the given year is needed by the accounting department. However, they said that they could see value in displaying the full depreciation schedule for all appropriate [Assets](Assets.md) (including those two items for each year).

Each [Asset](Assets.md) should have a column that records when its value is fully depreciated so that we can exclude fully depreciated items when pulling the above report. Storing that value seems like it would be cheaper than calculating it each time, though it would need to be recalculated any time a [Category's](Categories.md) Deduction Method or an [Asset's](Asset.md) In-Service Date is modified. That could result in slow updates to simple forms, so it could be more appropriate to calculate all depreciation for all items, and only displaying the appropriate ones... Meh, I'm just not sure.