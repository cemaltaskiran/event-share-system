<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('includes.head')
    </head>
    <body class="page1" id="top">
        <header>
            @include('includes.header')
        </header>
        <div class="slider_wrapper">
            @include('includes.slider')
        </div>
        <div class="content">
            <div class="container_12">
                <div class="grid_4">
                    <div class="banner">
                        <img class="banner_img" src="images/ban_img1.jpg" alt="">
                        <div class="label">
                            <div class="title">13. RLC Günleri</div>
                            <div class="date">28 Şubat - 2 Mart</div>
                            <a href="#">Sayfaya git</a>
                        </div>
                    </div>
                </div>
                <div class="grid_4">
                    <div class="banner">
                        <img class="banner_img" src="images/ban_img2.jpg" alt="">
                        <div class="label">
                            <div class="title">12. İltek Günleri</div>
                            <div class="date">28 Mart - 31 Mart</div>
                            <a href="#">Sayfaya git</a>
                        </div>
                    </div>
                </div>
                <div class="grid_4">
                    <div class="banner">
                        <img class="banner_img" src="images/ban_img3.jpg" alt="">
                        <div class="label">
                            <div class="title">TOSFED Gözetmen Eğitim Semineri</div>
                            <div class="date">10 Şubat</div>
                            <a href="#">Sayfaya git</a>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <div class="grid_6">
                    <h3>Booking Form</h3>
                    <form id="bookingForm">
                        <div class="fl1">
                            <div class="tmInput">
                                <input name="Name" placeHolder="Name:" type="text" data-constraints='@NotEmpty @Required @AlphaSpecial'>
                            </div>
                            <div class="tmInput">
                                <input name="Country" placeHolder="Country:" type="text" data-constraints="@NotEmpty @Required">
                            </div>
                        </div>
                        <div class="fl1">
                            <div class="tmInput">
                                <input name="Email" placeHolder="Email:" type="text" data-constraints="@NotEmpty @Required @Email">
                            </div>
                            <div class="tmInput mr0">
                                <input name="Hotel" placeHolder="Hotel:" type="text" data-constraints="@NotEmpty @Required">
                            </div>
                        </div>
                        <div class="clear"></div>
                        <strong>Check-in</strong>
                        <label class="tmDatepicker">
                                    <input type="text" name="Check-in" placeHolder='10/05/2014' data-constraints="@NotEmpty @Required @Date">
                                </label>
                        <div class="clear"></div>
                        <strong>Check-out</strong>
                        <label class="tmDatepicker">
                                    <input type="text" name="Check-out" placeHolder='20/05/2014' data-constraints="@NotEmpty @Required @Date">
                                </label>
                        <div class="clear"></div>
                        <div class="tmRadio">
                            <p>Comfort</p>
                            <input name="Comfort" type="radio" id="tmRadio0" data-constraints='@RadioGroupChecked(name="Comfort", groups=[RadioGroup])' checked/>
                            <span>Cheap</span>
                            <input name="Comfort" type="radio" id="tmRadio1" data-constraints='@RadioGroupChecked(name="Comfort", groups=[RadioGroup])' />
                            <span>Standart</span>
                            <input name="Comfort" type="radio" id="tmRadio2" data-constraints='@RadioGroupChecked(name="Comfort", groups=[RadioGroup])' />
                            <span>Lux</span>
                        </div>
                        <div class="clear"></div>
                        <div class="fl1 fl2">
                            <em>Adults</em>
                            <select name="Adults" class="tmSelect auto" data-class="tmSelect tmSelect2" data-constraints="">
                                        <option>1</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                            <div class="clear"></div>
                            <em>Rooms</em>
                            <select name="Rooms" class="tmSelect auto" data-class="tmSelect tmSelect2" data-constraints="">
                                        <option>1</option>
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                    </select>
                        </div>
                        <div class="fl1 fl2">
                            <em>Children</em>
                            <select name="Children" class="tmSelect auto" data-class="tmSelect tmSelect2" data-constraints="">
                                        <option>0</option>
                                        <option>0</option>
                                        <option>1</option>
                                        <option>2</option>
                                    </select>
                        </div>
                        <div class="clear"></div>
                        <div class="tmTextarea">
                            <textarea name="Message" placeHolder="Message" data-constraints='@NotEmpty @Required @Length(min=20,max=999999)'></textarea>
                        </div>
                        <a href="#" class="btn" data-type="submit">Submit</a>
                    </form>
                </div>
                <div class="grid_5 prefix_1">
                    <h3>Welcome</h3>
                    <img src="images/page1_img1.jpg" alt="" class="img_inner fleft">
                    <div class="extra_wrapper">
                        <p>Lorem ipsum dolor sit ere amet, consectetur ipiscin.</p>
                        In mollis erat mattis neque facilisis, sit ametiol
                    </div>
                    <div class="clear cl1"></div>
                    <p>Find the detailed description of this <span class="col1"><a href="http://blog.templatemonster.com/free-website-templates/" rel="dofollow">freebie</a></span> at TemplateMonster blog.</p>
                    <p><span class="col1"><a href="http://www.templatemonster.com/category/travel-website-templates/" rel="nofollow">Travel Website Templates</a></span> category offers you a variety of designs that are perfect for travel sphere of business.</p>
                    Proin pharetra luctus diam, a scelerisque eros convallis
                    <h4>Clients’ Quotes</h4>
                    <blockquote class="bq1">
                        <img src="images/page1_img2.jpg" alt="" class="img_inner noresize fleft">
                        <div class="extra_wrapper">
                            <p>Duis massa elit, auctor non pellentesque vel, aliquet sit amet erat. Nullam eget dignissim nisi, aliquam feugiat nibh. </p>
                            <div class="alright">
                                <div class="col1">Miranda Brown</div>
                                <a href="#" class="btn">More</a>
                            </div>
                        </div>
                    </blockquote>
                </div>
                <div class="grid_12">
                    <h3 class="head1">Latest News</h3>
                </div>
                <div class="grid_4">
                    <div class="block1">
                        <time datetime="2014-01-01">10<span>Jan</span></time>
                        <div class="extra_wrapper">
                            <div class="text1 col1"><a href="#">Aliquam nibh</a></div>
                            Proin pharetra luctus diam, any scelerisque eros convallisumsan. Maecenas vehicula egestas
                        </div>
                    </div>
                </div>
                <div class="grid_4">
                    <div class="block1">
                        <time datetime="2014-01-01">21<span>Jan</span></time>
                        <div class="extra_wrapper">
                            <div class="text1 col1"><a href="#">Etiam dui eros</a></div>
                            Any scelerisque eros vallisumsan. Maecenas vehicula egestas natis. Duis massa elit, auctor non
                        </div>
                    </div>
                </div>
                <div class="grid_4">
                    <div class="block1">
                        <time datetime="2014-01-01">15<span>Feb</span></time>
                        <div class="extra_wrapper">
                            <div class="text1 col1"><a href="#">uamnibh Edeto</a></div>
                            Ros convallisumsan. Maecenas vehicula egestas venenatis. Duis massa elit, auctor non
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer>
            <div class="container_12">
                <div class="grid_12">
                    <div class="socials">
                        <a href="#" class="fa fa-facebook"></a>
                        <a href="#" class="fa fa-twitter"></a>
                        <a href="#" class="fa fa-google-plus"></a>
                    </div>
                    <div class="copy">
                        Your Trip (c) 2014 | <a href="#">Privacy Policy</a> | Website Template Designed by <a href="http://www.templatemonster.com/" rel="nofollow">TemplateMonster.com</a>
                    </div>
                </div>
            </div>
        </footer>
        <script>
            $(function() {
                $('#bookingForm').bookingForm({
                    ownerEmail: '#'
                });
            })
            $(function() {
                $('#bookingForm input, #bookingForm textarea').placeholder();
            });
        </script>
    </body>
</html>