<div class="row">
    <div class="col-md-offset-1 col-md-5">
        <% if $QuoteForm %>
            <h1>Create a Quote</h1>
            $QuoteForm
        <% end_if %>
    </div>
    <div class="col-md-offset-1 col-md-5">
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