<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <svg width="49" height="50" viewBox="0 0 49 50" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M-1 0V50H49V0H-1ZM27.8015 42.03C21.49 43.105 14.764 41.5165 9.487 37.088L13.95 31.7675C17.9335 35.1105 23.1055 36.105 27.801 34.9305V42.03H27.8015ZM27.8015 16.256C26.85 15.234 25.498 14.5905 23.994 14.5905C21.122 14.5905 18.7855 16.927 18.7855 19.798C18.7855 22.67 21.1215 25.007 23.994 25.007C25.4975 25.007 26.8495 24.363 27.8015 23.341V31.3315C26.6025 31.729 25.3245 31.951 23.994 31.951C17.293 31.951 11.841 26.4995 11.841 19.7975C11.841 13.097 17.293 7.6455 23.994 7.6455C25.3245 7.6455 26.602 7.8675 27.8015 8.265V16.256Z" fill="#EE6636"></path>
      </svg>
      </div>
      <h1>INVOICE Ger-{{str_pad($invoice->id,6,'0',STR_PAD_LEFT)}}</h1>
      <div id="company" class="clearfix">
        <div>Company Name</div>
        <div>455 Foggy Heights,<br /> AZ 85004, US</div>
        <div>(602) 519-0450</div>
        <div><a href="mailto:company@example.com">company@example.com</a></div>
      </div>
      <div id="project">
        <div><span>CLIENT</span> {{$invoice->user->name}}</div>
        <div><span>EMAIL</span> <a href="mailto:{{$invoice->user->email}}">{{$invoice->user->email}}</a></div>
        <div><span>DATE</span> {{\Carbon\Carbon::parse($invoice->created_at)->toFormattedDateString()}}</div>
        <div><span>DUE DATE</span> {{\Carbon\Carbon::parse($invoice->created_at)->addDays(3)->toFormattedDateString()}}</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th class="desc">DESCRIPTION</th>
            <th>PRICE</th>
            <th>QTY</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="desc">{{$invoice->description}} ({{$invoice->credits}})</td>
            <td class="unit">${{$invoice->price}}</td>
            <td class="qty">1</td>
            <td class="total">${{$invoice->price}}</td>
          </tr>
          <tr>
            <td colspan="3">SUBTOTAL</td>
            <td class="total">${{$invoice->price}}</td>
          </tr>
          <tr>
            <td colspan="3" class="grand total">GRAND TOTAL</td>
            <td class="grand total">${{$invoice->price}}</td>
          </tr>
        </tbody>
      </table>
    </main>
    <style>
      .clearfix:after {
  content: "";
  display: table;
  clear: both;
}

a {
  color: #5D6975;
  text-decoration: underline;
}

body {
  position: relative;
  width: 21cm;  
  height: 29.7cm; 
  margin: 0 auto; 
  color: #001028;
  background: #FFFFFF; 
  font-family: Arial, sans-serif; 
  font-size: 12px; 
  font-family: Arial;
}

header {
  padding: 10px 0;
  margin-bottom: 30px;
}

#logo {
  text-align: center;
  margin-bottom: 10px;
}

#logo img {
  width: 90px;
}

h1 {
  border-top: 1px solid  #5D6975;
  border-bottom: 1px solid  #5D6975;
  color: #5D6975;
  font-size: 2.4em;
  line-height: 1.4em;
  font-weight: normal;
  text-align: center;
  margin: 0 0 20px 0;
  background: url(dimension.png);
}

#project {
  float: left;
}

#project span {
  color: #5D6975;
  text-align: right;
  width: 52px;
  margin-right: 10px;
  display: inline-block;
  font-size: 0.8em;
}

#company {
  float: right;
  text-align: right;
}

#project div,
#company div {
  white-space: nowrap;        
}

table {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  margin-bottom: 20px;
}

table tr:nth-child(2n-1) td {
  background: #F5F5F5;
}

table th,
table td {
  text-align: center;
}

table th {
  padding: 5px 20px;
  color: #5D6975;
  border-bottom: 1px solid #C1CED9;
  white-space: nowrap;        
  font-weight: normal;
}

table .service,
table .desc {
  text-align: left;
}

table td {
  padding: 20px;
  text-align: right;
}

table td.service,
table td.desc {
  vertical-align: top;
}

table td.unit,
table td.qty,
table td.total {
  font-size: 1.2em;
}

table td.grand {
  border-top: 1px solid #5D6975;;
}

#notices .notice {
  color: #5D6975;
  font-size: 1.2em;
}

footer {
  color: #5D6975;
  width: 100%;
  height: 30px;
  position: absolute;
  bottom: 0;
  border-top: 1px solid #C1CED9;
  padding: 8px 0;
  text-align: center;
}
    </style>
  </body>
</html>