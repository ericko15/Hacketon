import angular from 'angular';
import uirouter from 'angular-ui-router';
import styles from './styles.css'
import ngResource from 'angular-resource'

import routing from './routes';
import HomeController from './controller';
import ApiService from '../../services/apiService';

export default angular.module('app.home', [uirouter, ngResource])
  .config(routing)
	.controller('HomeController', HomeController)
	.service('ApiService', ApiService)
	.name;
