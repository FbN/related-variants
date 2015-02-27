[img]http://related-variants.demo.artefice.co/image/oc/intro-1.png[/img]
[url=http://related-variants.demo.artefice.co][img]http://related-variants.demo.artefice.co/image/oc/demo-button.png[/img][/url] [url=mailto:ftaioli@gmail.com][img]http://related-variants.demo.artefice.co/image/oc/support-button.png[/img][/url]
[b]What is RelatedVariants?[/b]

Having a product available in different variants is a very common situation in a ecommerce.

For example, take a fashion store that sells a t-shirt model T001. The model T001 exists in different colors (red,green,white) and sizes (S,M,L).

In OpenCart you can model this example using two options: one for color selection and one for the selection of size.

But this is not always the ideal solution because it has several drawbacks:
[list]
[*]For the customer it is difficult to understand the associations between pictures in the product gallery and every single available variant.

[*]Often a model in a color or other variant type has special features that would not be highlighted if all is presented to the customer in a single product page.

[*]If the customer search using "search field" for some of the features may not immediately find the product looking for.

[*]Indexing (SEO) of each product variant is more difficult and the you risk losing sales because customers cannot find proper object variant in Google results.

[*]If a variation is given by more combinations of options (eg. color / size) is more difficult to show the customer the status of the stock and the price of the object.

[/list]
To solve the problems seen, many famous ecommerce, opting to create separate products for each variant (based on the main feature). 
[img]http://related-variants.demo.artefice.co/image/oc/famous-shop-sample.png[/img]
So if we take the example seen, the tshirt T001, you will create many products as for colors available (T001-red, white-T002, T003-green).
Each of these products will be correlated with the others.
In order to best implement this solution you need a system similar to "related products" but with some differences:
[list]
[*]You have to declare variant types and their localized description (ie Color)

[*]Every item can have zero o one related variant type (ie T001-white have a Color variant).

[*]Every item is related to every other variant. (ie. correlate T001-red to T001-white imply correlate T001-white to T001-red).
[/list]
[b]Related Variants[/b] extension implement this behavior.

Please click on Documentation for installation and usage guide.

Free with [url=https://gnu.org/licenses/agpl-3.0.txt]AGPL License[/url]

Contact me for alternative license type.
