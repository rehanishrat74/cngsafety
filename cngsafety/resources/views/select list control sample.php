
                var opt = document.createElement('option');
                opt.value = 'All';
                opt.text = '* (All cities)';
                cities.options.add(opt);

                for (var i =0;i<citycount;i++){
                var opt = document.createElement('option');
                opt.value = responseD[i].city;
                opt.text = responseD[i].city;
                cities.options.add(opt);                    
                }