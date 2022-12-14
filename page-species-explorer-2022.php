<?php
/*
	Template Name: Species Explorer 2022
*/
?>

<?php get_header(); the_post(); ?>

<script language="Javascript">
	var info_on = false;
	function showInfo(text=false) {
		document.getElementById("information-overlay").style.display = 'flex';
		if (text) {document.getElementById("information-content").innerText = text;}
		info_on = true;
	}
	function hideInfo() {
		document.getElementById("information-overlay").style.display = 'none';
		info_on = false;
	}
	function toggleInfo(text=false) {
		var eleTxt = document.getElementById("information-content");
		if (eleTxt) {
			if (!info_on || `${text}` != `${eleTxt.innerText}`) {showInfo(text);} else {hideInfo();}
		} else {console.log(`No element with id 'information-content'`); }
	}
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">

  <section class="hero">

  	<div class="content">

      <div class="hero-header-info-icon">
  		  <h2 style="display: inline-block;">Species Explorer</h2>
        <a href="#" onclick="toggleInfo('The Species Explorer does a full text search of the Checklist of Vermont Species on GBIF. Text is searched against Scientific Name, Common Name, and Species Description.');"
          style="display: inline-block; vertical-align: top;">
          <i class="fa fa-info-circle"></i>
        </a>`;
      </div>

  		<form id="searchform" onsubmit="return false;" >

				<input id="results_search"
          autocomplete="off"
          list="gbif_autocomplete_list"
          class="search-field"
          type="text"
          placeholder="Search the Atlas..."
          onClick="this.setSelectionRange(0, this.value.length)"
          />
  			<datalist id="gbif_autocomplete_list"></datalist>

  			<div class="searchsubmit-wrap">
  				<button id="results_search_button">
  					<i class="far fa-search"></i>
  				</button>
  			</div>

  		</form>

  	</div>

  	<span class="overlay"></span>

  </section>

  <section>

  	<div class="container species-display">

			<div class="row">

        <div class="col-lg-4 col-md-6 col-xs-12" id="search-term">
    			<label id="search-value"></label>
    		</div>

        <div class="col-lg-2 col-md-6 col-xs-6">
          <ul class="pagination">
            <li id="rank-list" class="page-item page-list">
              <label id="select-label">Filter by Rank</label>
              <select id="taxon-rank" class="page-link" title="Filter Search Results by Taxon Rank">
                <option value="ALL">All</option>
                <option value="KINGDOM">Kingdom</option>
                <option value="PHYLUM">Phylum</option>
                <option value="CLASS">Class</option>
                <option value="ORDER">Order</option>
                <option value="FAMILY">Family</option>
                <option value="GENUS">Genus</option>
                <option value="SPECIES">Species</option>
                <option value="SUBSPECIES">Subspecies</option>
                <option value="VARIETY">Variety</option>
              </select>
            </li>
            <li id="page-list" class="page-item page-list">
              <label id="select-label">Recs/page</label>
              <select id="page-size" class="page-link" title="Number of Records to Show per Page - Also Applies to Download Page-Size">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="500">500</option>
                <option value="1000">1000</option>
              </select>
            </li>
          </ul>
        </div>

        <div class="col-lg-3 col-md6 col-xs-12">
          <ul class="pagination">
            <li id="page-first" class="page-item"><a class="page-link">First</a></li>
            <li id="page-prev" class="page-item"><a class="page-link">Prev</a></li>
            <li class="page-item"><a id="page-number" class="page-link">Page 1</a></li>
            <li id="page-next" class="page-item"><a class="page-link">Next</a></li>
            <li id="page-last" class="page-item"><a class="page-link">Last</a></li>
          </ul>
        </div>

        <div class="col-lg-3 col-md-6 col-xs-12" id="species-download">
          <button class="btn btn-link" id="download-csv" type="submit" title="Download CSV">
            <i class="fa fa-download" aria-hidden="true"></i>
            CSV
          </button>
          <button class="btn btn-link" id="download-json" type="submit" title="Download JSON">
            <i class="fa fa-download" aria-hidden="true"></i>
            JSON
          </button>
          <a class="btn btn-link" id="flag-issue"
            href=""
            target="_blank"
            title="Flag an issue with VT Species Info"
            >
            <i class="fa-solid fa-flag" aria-hidden="true"></i>
          </a>
        </div>

      </div>

      <div class="centered-text">
          <label id="download-progress" class="download-progress">Downloading...</label>
      </div>

      <div id="download-overlay"></div>

      <div id="information-overlay">
        <p id="information-content">
          Click Scientific Name to list all its child taxa.
        </p>
        <button class="btn btn-primary" id="information-button" onclick="hideInfo();">Ok</button>
      </div>

      <div id="species-results">
  			<table id="species-table" class="table table-striped table-sm">
        </table>
  		</div>

  	</div>

  </section>

<?php get_footer(); ?>

<script src="/wp-content/themes/val/js/gbif_auto_complete.js" type="module"></script>
<script src="/wp-content/themes/val/js/gbif_species_results.js" type="module"></script>
