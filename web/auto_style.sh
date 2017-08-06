#!/bin/bash


#ssh -i ~/.ssh/gslave02 -p 2223 nari@140.123.97.173

echo test<br>
echo $0<br>
echo $1<br>
scp -i ~/.ssh/gslave02 -P 2223 uploads/$1 nari@140.123.97.173:~/style_transfer/neural-style
#scp -i ~/.ssh/gslave02 -P 2223 uploads/test_150.jpg nari@140.123.97.173:~/style_transfer/neural-style


