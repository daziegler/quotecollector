<div class="row">
    <div class="col-md-6">
        <% if $QuoteForm %>
            <h1>Create a Quote</h1>
            $QuoteForm
        <% end_if %>
    </div>
    <div class="col-md-6">
        <% if $QuoteSearchForm %>
            <h1>Search for a Quote</h1>
            $QuoteSearchForm
        <% end_if %>
    </div>
</div>

<% include Quote %>