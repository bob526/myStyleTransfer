#include <iostream>
#include <opencv2/opencv.hpp>
#include <cstdlib>
#include <string>

using namespace cv;
using namespace std;

int main(int argc, char *argv[])
{
	// Correct Command line argument: Exec video.mp4 time
	if (argc<3) {
		cout<<"Argument Error"<<endl;
		return -1;
	}
	//cout<<argv[1]<<endl;
	int timeBetween = atoi(argv[2]);
	string testStr(argv[1]); 
	//cout<<timeBetween<<endl;
	VideoCapture targetVideo;
	targetVideo.open(testStr);


	return 0;
}
