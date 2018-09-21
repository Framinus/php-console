# PHP Testing App for the HelloSign PHP SDK

This is a console app to test the HelloSign PHP SDK. It currently only has three basic functions, but more will be added. Most of the functions will use the SDK, but there is a signature request option that uses the [httpful](https://github.com/nategood/httpful) library, as well.

## Install

Fork and clone this repository and run `composer install` to get all required dependencies.

Sign up for an API Account on HelloSign.com and get an API key.

Create a .env file in the root directory with the following:

```
API_KEY='YOUR_KEY'
```

## Author

[James McCormack](https://github.com/framinus)
