<div id="main">
    <div class="container-fluid">
        <% if $CurrentMember %>
            <section class="main special">
                <header class="major logoutButton">
                    <a class="button" href="$BaseHref./Security/Logout">Logout</a>
                </header>
            </section>

            <div class="row">
                <div class="col-md-offset-1 col-md-10 col-xs-offset-1 col-xs-10">
                    <% if $QuoteForm %>
                        <h1>Create a Quote</h1>
                        $QuoteForm
                    <% end_if %>
                </div>
            </div>

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#quote">Quotes</a></li>
                <li><a data-toggle="tab" href="#search">Search</a></li>
            </ul>

            <div class="tab-content">
                <div id="quote" class="tab-pane fade in active">
                    <% include Quote %>

                    <div class="row">
                        <div class="col-md-offset-5 col-md-2 center">
                            <% include Pagination %>
                        </div>
                    </div>
                </div>
                <div id="search" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10 col-xs-offset-1 col-xs-10 quoteForm">
                            <% if $QuoteSearchForm %>
                                <h1>Search for a Quote</h1>
                                $QuoteSearchForm
                            <% end_if %>
                        </div>
                    </div>
                    <% include Quote %>

                    <div class="row">
                        <div class="col-md-offset-5 col-md-2 center">
                            <% include Pagination %>
                        </div>
                    </div>
                </div>
            </div>
            <a href="#" class="back-to-top">
                <i class="fa fa-arrow-circle-up"></i>
            </a>
        <% else %>
            <% include Restricted %>
        <% end_if %>
    </div>
</div>