import homeTemplate from './home.html'

routes.$inject = ['$stateProvider'];

export default function routes($stateProvider) {
	$stateProvider
    .state('home', {
      url: '/',
      templateUrl: `public/${homeTemplate}`,
      controller: 'HomeController',
      controllerAs: 'home'
    });
}
