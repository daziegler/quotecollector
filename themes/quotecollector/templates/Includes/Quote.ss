<% if $Results %>
    <div class="row">
        <div class="col-md-offset-4 col-md-4 col-xs-offset-3 col-xs-6 center">
            <h3>Showing results $Results.FirstItem - $Results.LastItem ($Results.getTotalItems total)</h3>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <% loop $Results %>
                <div class="col-md-offset-1 col-md-5 col-sm-6 col-xs-12 quoteWrapper">
                    <% if $QuoteHeader %>
                        <h2>$QuoteHeader</h2>
                        <blockquote>
                    <% else %>
                        <blockquote class="noHeader">
                    <% end_if %>
                        <p>$QuoteContent</p>
                        <footer>$OriginalAuthor
                            <% if $AdditionalInfo %>
                                in <cite title="Source Title">$AdditionalInfo</cite>
                            <% end_if %>
                        </footer>
                    </blockquote>
                    <% if $Tags %>
                        <ul class="list-inline taglist">
                            <% loop $Tags %>
                                <li class="tag">$Title</li>
                            <% end_loop %>
                        </ul>
                    <% end_if %>
                    <a href="{$Top.Link}edit/{$ID}">edit</a> | <a href="{$Top.Link}delete/{$ID}">delete</a>
                </div>
            <% end_loop %>
        </div>
    </div>
<% else %>
    <div class="col-md-offset-5 col-md-3 center">
        <h1>NO RESULTS FOUND!</h1>
    </div>
<% end_if %>
