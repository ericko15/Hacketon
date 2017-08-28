// Dependencies
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css';
import angular from 'angular';
import uiRouter from 'angular-ui-router';
import 'babel-polyfill';

// App Config
import config from './app.config';

// Modules
import Home from './feactures/Home';

// Globals
import Navbar from './global/Navbar/navbar.html'

angular.module('app', [uiRouter, Home]).config(config)
