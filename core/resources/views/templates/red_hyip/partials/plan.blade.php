@foreach ($plans as $k => $plan)
    <div class="col-xl-4 col-md-6 gy-3">
        <div class="plan-item">
            <h3 class="plan-item__parcentage">@lang('Profit'):
                {{ $plan->interest_type != 1 ? $general->cur_sym : '' }}{{ showAmount($plan->interest) }}{{ $plan->interest_type == 1 ? '%' : '' }}
            </h3>
            <div class="plan-item__shape"></div>
            <div class="plan-item__card">
                <div class="plan-item__card-inner">
                    <div class="plan-item__content">
                        <div class="plan-item__header">
                            <h3 class="plan-item__title">{{ __($plan->name) }}</h3>
                        </div>
                        <div class="plan-item__body">
                            <ul class="text-list">
                                <li class="text-list__item"> <span class="icon"><i class="fas fa-check-circle"></i></span> @lang('Every')
                                    {{ __($plan->timeSetting->name) }} </li>
                                <li class="text-list__item"> <span class="icon"><i class="fas fa-check-circle"></i></span>@lang('For')

                                    @if ($plan->lifetime == 0)
                                        {{ __($plan->repeat_time) }} {{ __($plan->timeSetting->name) }}
                                    @else
                                        @lang('Lifetime')
                                    @endif
                                </li>
                                <li class="text-list__item"> <span class="icon"><i class="fas fa-check-circle"></i></span>
                                    @if ($plan->lifetime == 0)
                                        @lang('Total')
                                        {{ $plan->interest_type != 1 ? $general->cur_sym : '' }}{{ __($plan->interest * $plan->repeat_time) }}{{ $plan->interest_type == 1 ? '%' : '' }}
                                        @if ($plan->capital_back == 1)
                                            +
                                            <span class="badge badge--base ">
                                                @lang('Capital')
                                            </span>
                                        @endif
                                    @else
                                        @lang('Unlimited Earning')
                                    @endif
                                </li>
                                @if ($plan->compound_interest)
                                    <li class="text-list__item">
                                        <span class="icon"><i class="fas fa-check-circle"></i></span>
                                        @lang('Compound interest available')
                                    </li>
                                @endif
                                @if ($plan->hold_capital)
                                    <li class="text-list__item">
                                        <span class="icon"><i class="fas fa-check-circle"></i></span>
                                        @lang('Hold capital & reinvest')
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="plan-item__footer">
                        <div class="plan-item__footer-inner">
                            @if ($plan->fixed_amount == 0)
                                <span class="plan-item__footer-text d-block">@lang('Min :')
                                    {{ $general->cur_sym }}{{ showAmount($plan->minimum) }}</span>
                                <span class="plan-item__footer-text d-block">@lang('Max :')
                                    {{ $general->cur_sym }}{{ showAmount($plan->maximum) }}</span>
                            @else
                                <span class="plan-item__footer-text d-block">@lang('Fixed :')
                                    {{ $general->cur_sym }}{{ showAmount($plan->fixed_amount) }}</span>
                                <div class="mb-5"></div>
                            @endif

                            <a href="javascript:void(0)" class="btn btn--white pill investModal" data-bs-toggle="modal" data-plan="{{ $plan }}" data-bs-target="#investModal">@lang('Invest Now')</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach


<div class="modal custom--modal fade" id="investModal">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                @if (auth()->check())
                    <strong class="modal-title " id="ModalLabel">
                        @lang('Confirm to invest on') <span class="planName"></span>
                    </strong>
                @else
                    <strong class="modal-title " id="ModalLabel">
                        @lang('At first login your account')
                    </strong>
                @endif
                <button class="close" class="text--base" data-bs-dismiss="modal">
                    <i class="las la-times"></i>
                </button>
            </div>
            <form action="{{ route('user.invest.submit') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="plan_id">
                    @if (auth()->check())
                        <div class="modal-body">
                            <div class="form-group">
                                <h6 class="text-center investAmountRange"></h6>
                                <p class="text-center mt-1 interestDetails"></p>
                                <p class="text-center interestValidity"></p>
                                <p class="text-center calculatedInterest"></p>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Pay Via')</label>
                                        <select class="form--control select" name="wallet_type" required>
                                            <option value="">@lang('Select One')</option>
                                            @if (auth()->user()->deposit_wallet > 0)
                                                <option value="deposit_wallet">@lang('Deposit Wallet - ' . $general->cur_sym . showAmount(auth()->user()->deposit_wallet))</option>
                                            @endif
                                            @if (auth()->user()->interest_wallet > 0)
                                                <option value="interest_wallet">@lang('Interest Wallet -' . $general->cur_sym . showAmount(auth()->user()->interest_wallet))</option>
                                            @endif
                                            @foreach ($gatewayCurrency as $data)
                                                <option value="{{ $data->id }}" @selected(old('wallet_type') == $data->method_code) data-gateway="{{ $data }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        <code class="gateway-info rate-info d-none">@lang('Rate'): 1 {{ $general->cur_text }}
                                            = <span class="rate"></span> <span class="method_currency"></span></code>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang('Invest Amount')</label>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control form--control" name="amount" required>
                                            <span class="input-group-text bg--base">{{ $general->cur_text }}</span>
                                        </div>
                                        <code class="gateway-info d-none">@lang('Charge'): <span class="charge"></span>
                                            {{ $general->cur_text }}. @lang('Total amount'): <span class="total"></span>
                                            {{ $general->cur_text }}</code>
                                    </div>
                                </div>


                                <div class="col-md-6 compoundInterest">
                                    <div class="form-group">
                                        <label>@lang('Compound Interest') (@lang('optional'))</label>
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control form--control" name="compound_interest">
                                            <div class="input-group-text bg--base">@lang('Times')</div>
                                        </div>
                                        <small class="fst-italic text--info"><i class="las la-info-circle"></i> @lang('Your interest will add to the investment capital amount for a specific time that you\'re entering.')</small>
                                    </div>
                                </div>
                                @if ($general->schedule_invest)
                                    <div class="col-md-6 investTime">
                                        <div class="form-group">
                                            <label>@lang('Auto Schedule Invest')</label>
                                            <select class="form--control  select" name="invest_time" required>
                                                <option value="invest_now">@lang('Invest Now')</option>
                                                <option value="schedule">@lang('Schedule')</option>
                                            </select>
                                            <small class="fst-italic text--info"><i class="las la-info-circle"></i> @lang('You can set your investment as a scheduler or invest instant.')</small>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            @if ($general->schedule_invest)
                                <div class="row schedule">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">@lang('Schedule For')</label>
                                            <div class="input-group">
                                                <input type="number" min="0" class="form-control form--control" name="schedule_times">
                                                <span class="input-group-text bg--base">@lang('Times')</span>
                                            </div>
                                            <small class="fst-italic text--info"><i class="las la-info-circle"></i> @lang('Set how many times you want to invest.')</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="required">@lang('After')</label>
                                            <div class="input-group">
                                                <input type="number" class="form-control form--control" name="hours" min="0">
                                                <span class="input-group-text bg--base">@lang('Hours')</span>
                                            </div>
                                            <small class="fst-italic text--info"><i class="las la-info-circle"></i> @lang('Set a frequency at which you prefer to make investments.')</small>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @else
                        <p>@lang('Login Required')</p>
                    @endif
                </div>
                <div class="modal-footer">
                    @if (auth()->check())
                        <button type="button" class="btn btn-secondary btn-sm text-black" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn--base btn-sm">@lang('Yes')</button>
                    @else
                        <a href="{{ route('user.login') }}" class="btn btn--base btn-sm h-45 w-100 text-center">@lang('Login Now')</a>
                    @endif
                </div>
            </form>

        </div>
    </div>
</div>

@push('style')
    <style>
        .form--control:disabled,
        .form--control[readonly] {
            background-color: hsl(var(--base-two-d-200));
            opacity: 1;
            border: 1px solid hsl(var(--white)/0.15);
        }

        .custom--modal .modal-body .select {
            margin-bottom: 10px;
        }

        .custom--modal .modal-body label {
            margin-bottom: 10px;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"
            var symbol = '{{ $general->cur_sym }}';
            var currency = '{{ $general->cur_text }}';
            var plan;

            $('.investModal').click(function() {
                $('.gateway-info').addClass('d-none');
                var modal = $('#investModal');
                plan = $(this).data('plan');
                modal.find('.planName').text(plan.name)
                modal.find('[name=plan_id]').val(plan.id);
                let fixedAmount = parseFloat(plan.fixed_amount).toFixed(2);
                let minimumAmount = parseFloat(plan.minimum).toFixed(2);
                let maximumAmount = parseFloat(plan.maximum).toFixed(2);
                let interestAmount = parseFloat(plan.interest);

                if (plan.fixed_amount > 0) {
                    modal.find('.investAmountRange').text(`Invest: ${symbol}${fixedAmount}`);
                    modal.find('[name=amount]').val(fixedAmount);
                    modal.find('[name=amount]').attr('readonly', true);
                } else {
                    modal.find('.investAmountRange').text(
                        `Invest: ${symbol}${minimumAmount} - ${symbol}${maximumAmount}`);
                    modal.find('[name=amount]').val('');
                    modal.find('[name=amount]').removeAttr('readonly');
                }

                if (plan.interest_type == '1') {
                    modal.find('.interestDetails').html(`<strong> Interest: ${interestAmount}% </strong>`);
                } else {
                    modal.find('.interestDetails').html(
                        `<strong> Interest: ${interestAmount} ${currency}  </strong>`);
                }
                if (plan.lifetime == '0') {
                    modal.find('.interestValidity').html(
                        `<strong>  Per ${plan.time_setting.time} hours ,  ${plan.repeat_time} times</strong>`);
                } else {
                    modal.find('.interestValidity').html(
                        `<strong>  Per ${plan.time_setting.time} hours,  life time </strong>`);
                }

                if (plan.compound_interest == '1') {
                    $('.compoundInterest').show();
                    $('.investTime').removeClass('col-md-12');
                } else {
                    $('.compoundInterest').hide();
                    $('.investTime').addClass('col-md-12');
                }
                calculateInterest();
            });

            $('[name=amount]').on('input', function() {
                $('[name=wallet_type]').trigger('change');
                calculateInterest();
            })

            $('[name=wallet_type]').change(function() {
                var amount = $('[name=amount]').val();
                if ($(this).val() != 'deposit_wallet' && $(this).val() != 'interest_wallet' && amount) {
                    var resource = $('select[name=wallet_type] option:selected').data('gateway');
                    var fixed_charge = parseFloat(resource.fixed_charge);
                    var percent_charge = parseFloat(resource.percent_charge);
                    var charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                    $('.charge').text(charge);
                    $('.rate').text(parseFloat(resource.rate));
                    $('.gateway-info').removeClass('d-none');
                    if (resource.currency == '{{ $general->cur_text }}') {
                        $('.rate-info').addClass('d-none');
                    } else {
                        $('.rate-info').removeClass('d-none');
                    }
                    $('.method_currency').text(resource.currency);
                    $('.total').text(parseFloat(charge) + parseFloat(amount));
                } else {
                    $('.gateway-info').addClass('d-none');
                }
            });

            $('[name=invest_time]').on('change', function() {
                let investTime = $(this).find(':selected').val();
                if (investTime == 'invest_now') {
                    $('.schedule').hide();
                } else {
                    $('.schedule').show();
                }
            }).change();

            $('[name=schedule_times]').on('input', function() {
                let text = $(this).val() == 1 ? `@lang('After')` : `@lang('Every')`;
                $('[name=hours]').closest('.form-group').find('label').text(text);
            });

            $('[name=compound_interest]').on('input', function() {
                calculateInterest();
            })


            function calculateInterest() {
                let interest = parseFloat(plan.interest);
                let interestType = plan.interest_type; //1: percent, 0: fixed
                let repeatTime = plan.repeat_time;
                let capitalBack = plan.capital_back;
                let investAmount = $('[name=amount]').val() * 1;
                let compoundInterest = $('[name=compound_interest]').val() ?? 0;
                let calculatedInterest = 0;
                let baseInterest = 0;

                if (repeatTime == 0 || investAmount == 0) {
                    $('.calculatedInterest').hide();
                    return false;
                } else {
                    $('.calculatedInterest').show();
                }

                let totalInterest = interest * repeatTime;

                if (interestType == '1') {
                    if (compoundInterest > 0) {
                        let remainingRepeatTime = repeatTime - compoundInterest;
                        let interestRatio = 1 + interest / 100;
                        let compoundCapital = investAmount * Math.pow(interestRatio, compoundInterest);
                        totalInterest = (compoundCapital * interest / 100) * remainingRepeatTime;
                    } else {
                        totalInterest = interest * investAmount / 100 * repeatTime;
                    }
                }

                totalInterest = capitalBack ? totalInterest : totalInterest - investAmount;
                $('.calculatedInterest').text(`@lang('Total Profit') ` + symbol + totalInterest.toFixed(2));
            }

            @if (!$general->schedule_invest)
                console.log(3434);
                $('.modal-dialog').removeClass('modal-lg');
                $('.modal-dialog').find('.col-md-6').addClass('col-md-12');
            @endif

        })(jQuery);
    </script>
@endpush
