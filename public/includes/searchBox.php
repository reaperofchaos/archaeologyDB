<?php
echo "<!-- search box location -->
    <div class='searchBoxRow'>
        <!-- left column spacing -->
        <div class='col-sm-7'>
        </div>
        <!-- search box column sm-4 -->
        <div class='col-sm-4'>
            <div class='searchArea' style='float: right; padding: 10px;'>
                <!-- searchbox buttons -->
                <div class='btn-group'>
                    <button type='button' class='btn btn-primary' onclick='changeSearch(\"title\")'>Title</button>
                    <button type='button' class='btn btn-primary' onclick='changeSearch(\"author\")'>Author</button>
                    <button type='button' class='btn btn-primary' onclick='changeSearch(\"site\")'>Site</button>
                </div> 
                <!-- search box form -->
                <div class='form-group' id='searchlist'>
                    <div id='searchArticles' style='display:block'>
                        <label for='source_title'><strong>Search: </strong></label><input type='text' id='source_title' name='source_title' list='source' class='form-control' placeholder='Type Article Title'>
                        <button class='searchButton' name='searchSource'>Search</button>
                    </div>
                    <div id='searchAuthors' style='display:none'>
                        <label for='author_search'><strong>Search: </strong></label>
                        <input type='text' id='author_search' name='author_search' class='form-control' list='authors' placeholder='Type Author Name'>
                        <button class='searchButton' name='searchAuthor'>Search</button>
                    </div>
                    <div id='searchSites' style='display:none'>
                        <label for='site_name'><strong>Search: </strong></label>
                        <input type='text' id='site_name' name='site_name' class='form-control' list='sites' placeholder='Type Site Name'>
                        <button class='searchButton' name='searchSite'>Search</button>
                    </div>
                <!-- end searchbox form-->
                </div>
            <!-- end search area -->
            </div>
        <!-- end searchbox col-sm-4 -->
        </div>
        <!-- right column spacing -->
        <div class='col-sm-1'>
        </div>
    <!--- end searchbox row-->
    </div>";
?>
