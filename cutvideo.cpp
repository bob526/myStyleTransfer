// compile code
// $g++ -std=c++11 `pkg-config --cflags openc` filename `pkg-config --libs opencv'

//exe code
//$exe video time (dirName)
// if no dirName
//save in ./

#include <iostream>
#include <opencv2/opencv.hpp>
#include <cstdlib>
#include <string>

using namespace cv;
using namespace std;

int main(int argc, char *argv[])
{
    if (argc<3) {
        cout<<"Argument Error"<<endl;
        return -1;
    }
    //get times
    int timeBetween = atoi(argv[2]);
    //get video filename
    string testStr(argv[1]);
    //get dirname
    string dirName;
    if(argc < 4)
        dirName = ".";
    else
        dirName = argv[3];

    VideoCapture targetVideo;

    //open video file and check it
    targetVideo.open(testStr);
    if(!targetVideo.isOpened()) {
        cerr << "File is ont readed" << endl;
        return -1;
    }
    //image number
    int i = 1;

    namedWindow("edges",WINDOW_AUTOSIZE);

    //cout << "fps" << targetVideo.get(CV_CAP_PROP_FPS) << endl;

    //from 0 ms get frame
    for(int timediff = timeBetween;; timediff += timeBetween)
    {
        Mat frame;
        string imgName = dirName + "/img" + to_string(i) + ".jpg";
        targetVideo >> frame; // get a new frame
        // video end show
        if(frame.empty()) {
            cout << "video end" << endl;
            break;
        }
        //show the frame
        imshow("edges", frame);

        //save image
        imwrite(imgName,frame);
        //esc exit show
        if(waitKey(30) == 27) {
            cerr << "esc" << endl;
            break;
        }
        i++;
        // jump to next frame
        targetVideo.set(CV_CAP_PROP_POS_MSEC,timediff);
    }

    return 0;
}

