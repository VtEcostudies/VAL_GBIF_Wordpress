/*
  GBIF REACT EVENT SEARCH SCRIPTS
*/

import { dataConfig } from './gbif_data_config.js'; //in html must declare this as module eg. <script type="module" src="js/gbif_data_widget.js"></script>

var widgetLocale = 'en';

var siteTheme = gbifReactComponents.themeBuilder.extend({baseTheme: 'light', extendWith: {
  dense: true,
  primary: '#176f75',
  linkColor: '#176f75',
  fontSize: '15px',
  background: '#E7E7E7',
  paperBackground: '#ffffff',
  paperBorderColor: '#e0e0e0',
  color: '#162d3d',
  darkTheme: false,
  fontFamily: '"Roboto", BlinkMacSystemFont, -apple-system, "Segoe UI", "Roboto", "Oxygen", "Ubuntu", "Cantarell", "Fira Sans", "Droid Sans", "Helvetica", "Arial", sans-serif',
  borderRadius: 4,
  drawerZIndex: 50001
}});

var userTheme = typeof siteTheme !== 'undefined' ? siteTheme : undefined;
var userConfig = typeof siteConfig !== 'undefined' ? siteConfig : {};
var routes = userConfig.routes || {
    occurrenceSearch: {
    route: '/',
  }
};

//sometimes the widget inserts basename into path (eg. on page-reload). detect host and use relevant path.
if ('vtatlasoflife.org' == dataConfig.hostUrl || 'localhost' == dataConfig.hostUrl) {
  routes.basename = '/';
} else {
  routes.basename = '/gbif-explorer';
}

function getSuggestions({ client }) {
  return {
    gadmGid: {
      // how to get the list of suggestion data, before you would also have to define how to render the suggestion, but the new part I added means that below is enough
      getSuggestions: ({ q }) => {
        const { promise, cancel } = client.v1Get(`/geocode/gadm/search?gadmGid=${dataConfig.gadmGid}&limit=100&q=${q}`); // this gadmGid=USA.46_1 is the new part, that means that the suggester will now only suggest things in Vermont
        return {
          promise: promise.then(response => {
            return {
              data: response.data.results.map(x => ({ title: x.name, key: x.id, ...x }))
            }
          }),
          cancel
        }
      }
    }
  }
}

var occurrence = {
    mapSettings: dataConfig.mapSettings,
    rootPredicate: dataConfig.rootPredicate,
    highlightedFilters: ['q','taxonKey','gadmGid','locality','elevation','year','recordedBy','publishingOrg','datasetName'],
    excludedFilters: ['stateProvince', 'continent', 'country', 'publishingCountry', 'hostingOrganization', 'networkKey', 'publishingProtocol'],
    occurrenceSearchTabs: ['GALLERY', 'MAP', 'TABLE', 'DATASETS'], // what tabs should be shown
    defaultTableColumns: ['features','coordinates','locality','year','basisOfRecord','dataset','publisher','recordedBy','collectionCode','institutionCode'],
    getSuggests: getSuggestions,
 }

var apiKeys = {
   "maptiler": "qcDo0JkF6EBKzpW7hlYB"
}

var maps = {
  locale: 'en', // what language should be used for GBIF base maps? See https://tile.gbif.org/ui/ for available languages in basemaps
  defaultProjection: 'MERCATOR', // what is the default projection
  defaultMapStyle: 'NATURAL', // what is the default style
  mapStyles: {
    MERCATOR: ['NATURAL', 'SATELLITE', 'BRIGHT', 'DARK'],
    PLATE_CAREE: ['NATURAL', 'BRIGHT', 'DARK']
  },
}

ReactDOM.render(
  React.createElement(gbifReactComponents.OccurrenceSearch, {
    style: { 'min-height': 'calc(100vh - 80px)' },
    siteConfig: {
      theme: userTheme,
      routes: routes,
      locale: widgetLocale,
      occurrence: occurrence,
      apiKeys: apiKeys,
      maps: maps
    },
    pageLayout: true,
  }),
  document.getElementById('root')
);
