# 📖 PHP Glossary

PHP Glossary is a conceptual and demonstrative software tool designed to analyze source code 
and identify domain-specific terms associated with business logic. 
This utility aims to distinguish domain terms from general programming language keywords, 
helping developers gain insights into the crucial terms that define the project's specific functionality.

## Features

* **Term Analysis:** The tool scans source code files and identifies terms that are closely related to the project's business domain. It filters out common programming language keywords to focus solely on the terms that encapsulate the project's core concepts.

* **Domain Term Highlighting:** The software highlights the detected domain terms within the source code, making it easier for developers to visually identify key business-related elements.

* **Visualization:** PHP Glossary offers a simple visualization of the distribution of domain terms throughout the codebase. This visual representation can help developers gauge the prevalence and importance of different terms.

* **Conceptual and Demonstrative:** Please note that this project is intended to demonstrate the concept of domain term analysis. It is not production-ready and should not be used as a final solution for real-world applications.

## Installation

### Composer

To install this project as a dev dependency in your existing PHP project, you can use Composer's require command with the `--dev` flag:

```shell
composer require --dev javanile/php-glossary
```

This command will add the javanile/php-glossary package as a dev dependency to your project's `composer.json` file and install it along with its dev dependencies.

### Standalone

Download the latest release of file [`bin/glossary`](https://raw.githubusercontent.com/javanile/php-glossary/main/bin/glossary) and place it in the root directory of your project. 

```shell
curl -o glossary https://raw.githubusercontent.com/javanile/php-glossary/main/bin/glossary
```

## Usage

Create a file called `.glossaryrc` in the root directory of your project and add the following configuration:

```ini
[domain]
terms = Invoice, Customer, Product, Order, Payment, Shipment, Tax, Discount
``` 

Run the tool from the command line:

```shell
php vendor/bin/glossary
```

## Key Considerations

* The `.glossaryrc` file should serve as the central repository for domain-specific terms within the application. We envision tools that will keep this file updated by aggregating input from various sources, such as business logic analysis tools, etc.
* Developers should be educated and encouraged to select terms during development that are present in the `.glossaryrc` file.
* The official glossary and its representing file, the `.glossaryrc`, are integral parts of the project, much like tests and fixtures.
* If a developer modifies the glossary to pass CI/CD, they must justify it during the peer-review phase. This introduces the opportunity to have targeted checks solely on glossary files rather than throughout the entire codebase.

## ⚠️ Disclaimer

> This project is an educational demonstration and should not be used in a production environment. 
> It showcases the idea of identifying domain-specific terms in source code and is not optimized for real-world scenarios. 
> Use it as a starting point for understanding the potential of term analysis within software development.

## Contributions

Contributions to enhance and extend the capabilities of PHP Glossary are welcome. 
If you find value in this concept and wish to contribute, please follow the guidelines provided in the repository.

## License

This project is open-source and released under the MIT License. Feel free to use, modify, and distribute it in accordance with the license terms.
