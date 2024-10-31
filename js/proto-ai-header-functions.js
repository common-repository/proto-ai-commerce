/******** Wordpress Only Functions ********/

function updateShopifyCartVisitId() {
  // This function does not apply to woo commerce
  return false;
}

function protoAIWordpressInitialLoad() {
  displayProtoAIRecommendationsForGridWidget();
  protoAIBuildInitialDrawerRecommendationsHtmlStructure(window.protoAICurrentCurrencySymbol, window.protoAICurrentCurrencyIsoCode);
  var drawerContainer = document.getElementById("proto-ai-recs-drawer-container");

  if (drawerContainer !== null) {
    protoAIRecommendationsDrawer__initializer();
  }
  protoAIonClick();
}

function protoAIInitialLoad() {
  protoAIAuthorizeVisitor(protoAIWordpressInitialLoad);
}
