

<table style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px">
    <thead>
      <tr>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222" colspan="2">Order Details</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px"><b>Order ID:</b> {{ $order->id ?? ''}} <br>
          <b>Date Added:</b> {{ $order->created_at ?? ''}}<br>
          <b>Payment Method:</b> Cash On Delivery<br>

          </td>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px"><b>E-mail:</b> <a href="mailto:{{ $order->billing_email ?? ''}}" target="_blank">{{ $order->billing_email ?? ''}}</a><br>
          <b>Mobile NO:</b> {{ $order->billing_phone ?? ''}}<br>

          <b>Order Status:</b> {{ $status}}<br></td>
      </tr>
    </tbody>
  </table>




  <table style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px">
    <thead>
      <tr>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Billing Address</td>
         </tr>
    </thead>
    <tbody>
      <tr>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px">
            {{ $order->billing_name ?? ''}}
            <br>{{ $order->billing_address ?? ''}}
            <br>{{ $order->billing_city ?? ''}} {{ $order->billing_postalcode ?? ''}}
            <br>{{ $order->billing_province ?? ''}}
            <br>{{ $order->billing_phone ?? ''}}
        </td>
         </tr>
    </tbody>
  </table>



  <table style="border-collapse:collapse;width:100%;border-top:1px solid #dddddd;border-left:1px solid #dddddd;margin-bottom:20px">
    <thead>
      <tr>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Part Number</td>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:left;padding:7px;color:#222222">Model</td>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Quantity</td>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Price</td>
        <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;background-color:#efefef;font-weight:bold;text-align:right;padding:7px;color:#222222">Total</td>
      </tr>
    </thead>
    <tbody>

          <?php
            $i=0;
            ?>
        @foreach ($order_product as $item)

        <tr>

            <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px"> {{ $item->partno->part_number ?? ''}}
              </td>
            <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:left;padding:7px">{{ $item->partno->nominal_thread_m ?? ''}}</td>
            <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">{{ $item->quantity ?? '' }}</td>
            <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">₹{{ $item->partno->original_price ?? ''}}</td>
            <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">₹{{ $item->partno->original_price * $item->quantity }}</td>
          </tr>
             <?php
              $i +=$item->partno->original_price * $item->quantity ;
             ?>
        @endforeach
      </tbody>

    <tfoot>

        <tr>
      <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px" colspan="4"><b>Sub-Total:</b></td>
      <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">₹{{ $i }}</td>
        </tr>

        @if (isset($settings) && $settings->discount_status == 1)
        @php
        $discount = $i * (1 - $settings->discount / 100);
        @endphp
                <tr >
            <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px" colspan="4"><b>Discount({{ $settings->discount }})%:</b></td>
            <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">₹{{ $discount }}</td>
              </tr>
            @else
            @php
            $discount = $i;
             @endphp
            @endif



            @if (isset($settings) && $settings->igst)
            @php
               $igst =   ($i *  $settings->igst) / 100 ;
            @endphp
                    <tr>
                <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px" colspan="4"><b>IGST({{ $settings->igst }})%:</b></td>
                <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">₹{{ $igst }}</td>
                  </tr>
            @else

            @php
            $igst =  0;
            @endphp

            @endif




            @if (isset($settings) && $settings->cgst)
            @php
               $cgst =   ($i *  $settings->cgst) / 100 ;
            @endphp
                    <tr>
                <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px" colspan="4"><b>CGST({{ $settings->cgst }})%:</b></td>
                <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">₹{{ $cgst }}</td>
                  </tr>
            @else

            @php
            $cgst =  0;
            @endphp

            @endif

            @php
            $total =  $discount + $igst + $cgst ;
             @endphp

        <tr>
      <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px" colspan="4"><b>Total:</b></td>
      <td style="font-size:12px;border-right:1px solid #dddddd;border-bottom:1px solid #dddddd;text-align:right;padding:7px">₹{{ $total }}</td>
        </tr>
          </tfoot>

  </table>
