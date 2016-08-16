<div id="main">
    <div class="container-fluid">
        <% if $CurrentMember %>
            <section class="main special">
                <header class="major logoutButton">
                    <a class="button" href="$BaseHref./Security/Logout">Logout</a>
                </header>
            </section>
            <div class="row">
                <div class="col-md-offset-1 col-md-5 col-xs-offset-1 col-xs-10">
                    <% if $QuoteForm %>
                        <h1>Create a Quote</h1>
                        $QuoteForm
                    <% end_if %>
                </div>
                <div class="col-md-5 col-xs-offset-1 col-xs-10">
                    <% if $QuoteSearchForm %>
                        <h1>Search for a Quote</h1>
                        $QuoteSearchForm
                    <% end_if %>
                </div>
            </div>

            <a href="#" class="back-to-top">
                <i class="fa fa-arrow-circle-up"></i>
            </a>

            <% include Quote %>

            <div class="row">
                <div class="col-md-offset-5 col-md-2 center">
                    <% include Pagination %>
                </div>
            </div>
        <% else %>
            <% include Restricted %>
        <% end_if %>
    </div>
</div>